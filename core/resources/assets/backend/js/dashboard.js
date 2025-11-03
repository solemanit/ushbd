import $ from "jquery";

window.$ = $; // Ensure globally available (some plugins require this)
window.jQuery = $;

// Toggle password visibility
$(".toggle-password").on("click", function (e) {
    e.preventDefault();

    const $field = $(this).closest(".input-group").find(".password-field");
    const isPassword = $field.attr("type") === "password";

    $field.attr("type", isPassword ? "text" : "password");
});

// DOM ready
$(document).ready(function () {
    // ========== CATEGORY & SUBCATEGORY ========== //
    const categorySelect = document.getElementById("category");
    const subcategorySelect = document.getElementById("subcategory");
    const oldSubcategoryId =
        document.querySelector('input[name="old_subcategory_id"]')?.value ||
        null;
    // Dynamically get prefix
    const panelPrefix = window.panelPrefix || "admin"; // default fallback

    function loadSubcategories(categoryId, preselectId = null) {
        subcategorySelect.innerHTML = '<option value="">Loading...</option>';
        subcategorySelect.disabled = true;

        fetch(`/${panelPrefix}/course-modules/get-subcategories/${categoryId}`)
            .then((res) => {
                if (!res.ok) throw new Error("Network response was not ok");
                return res.json();
            })
            .then((data) => {
                subcategorySelect.innerHTML =
                    '<option value="">Select Subcategory</option>';
                data.forEach((subcat) => {
                    const option = document.createElement("option");
                    option.value = subcat.id;
                    option.textContent = subcat.name;
                    if (preselectId && subcat.id == preselectId) {
                        option.selected = true;
                    }
                    subcategorySelect.appendChild(option);
                });
                subcategorySelect.disabled = false;
            })
            .catch((err) => {
                console.error("Error fetching subcategories:", err);
                subcategorySelect.innerHTML =
                    '<option value="">Failed to load subcategories</option>';
                subcategorySelect.disabled = true;
            });
    }

    if (categorySelect && subcategorySelect) {
        categorySelect.addEventListener("change", function () {
            const categoryId = this.value;
            if (categoryId) {
                loadSubcategories(categoryId);
            } else {
                subcategorySelect.innerHTML =
                    '<option value="">Select Category first</option>';
                subcategorySelect.disabled = true;
            }
        });

        const oldCategoryId = categorySelect.value;
        if (oldCategoryId && oldSubcategoryId) {
            loadSubcategories(oldCategoryId, oldSubcategoryId);
        }
    }

    // ========== PRICING TOGGLE ========== //
    const freeRadio = document.getElementById("pricing_free");
    const paidRadio = document.getElementById("pricing_paid");
    const pricingInputs = document.getElementById("pricing_inputs");

    const priceInput = document.querySelector('input[name="price"]');
    const discountInput = document.querySelector('input[name="discount"]');

    function togglePricingInputs() {
        if (paidRadio?.checked) {
            pricingInputs.style.display = "flex";
            priceInput.required = true;
            discountInput.required = true;
        } else {
            pricingInputs.style.display = "none";
            priceInput.required = false;
            discountInput.required = false;
        }
    }

    if (freeRadio && paidRadio && pricingInputs) {
        freeRadio.addEventListener("change", togglePricingInputs);
        paidRadio.addEventListener("change", togglePricingInputs);
        togglePricingInputs();
    }

    // ========== COURSE TYPE (LIVE/RECORDED) SECTION TOGGLE ========== //
    const typeSelect = document.querySelector('select[name="type"]');
    const schedulingSection = document.querySelector("#scheduling_section");
    const enrollmentSection = document.querySelector("#enrollment_section");

    const batchNoInput = document.querySelector('input[name="batch_no"]');
    const classTimeInput = document.querySelector('input[name="class_time"]');
    const maxStudentInput = document.querySelector(
        'input[name="maximum_student"]'
    );
    const enrollmentStartInput = document.querySelector(
        'input[name="enrollment_start"]'
    );
    const enrollmentEndInput = document.querySelector(
        'input[name="enrollment_end"]'
    );

    function toggleSectionsVisibility() {
        const selectedType = typeSelect.value;
        const shouldShow =
            selectedType === "live" ||
            selectedType === "pre-recorded-with-live";

        schedulingSection.style.display = shouldShow ? "block" : "none";
        enrollmentSection.style.display = shouldShow ? "block" : "none";

        batchNoInput.required = shouldShow;
        classTimeInput.required = shouldShow;
        maxStudentInput.required = shouldShow;
        enrollmentStartInput.required = shouldShow;
        enrollmentEndInput.required = shouldShow;
    }

    if (typeSelect && schedulingSection && enrollmentSection) {
        typeSelect.addEventListener("change", toggleSectionsVisibility);
        toggleSectionsVisibility();
    }
});

// select

document.addEventListener("DOMContentLoaded", function () {
    const el = document.getElementById("select-field");

    if (el && window.TomSelect) {
        new TomSelect(el, {
            copyClassesToDropdown: false,
            dropdownParent: "body",
            controlInput: "<input>",
            render: {
                item: function (data, escape) {
                    if (data.customProperties) {
                        return (
                            '<div><span class="dropdown-item-indicator">' +
                            data.customProperties +
                            "</span>" +
                            escape(data.text) +
                            "</div>"
                        );
                    }
                    return "<div>" + escape(data.text) + "</div>";
                },
                option: function (data, escape) {
                    if (data.customProperties) {
                        return (
                            '<div><span class="dropdown-item-indicator">' +
                            data.customProperties +
                            "</span>" +
                            escape(data.text) +
                            "</div>"
                        );
                    }
                    return "<div>" + escape(data.text) + "</div>";
                },
            },
            onInitialize: function () {
                console.log("TomSelect initialized");
            },
        });
    }
});

$(document).ready(function () {
    // When the file input changes
    $('input[name="image"]').on("change", function () {
        var input = this;
        var $preview = $("#imagePreview");

        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $preview.attr("src", e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    });
});
