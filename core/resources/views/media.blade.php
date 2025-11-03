<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Resumable.js + Laravel Chunk Upload</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/resumable.js/1.1.0/resumable.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>

<div class="container pt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">
                    <h5>Upload File</h5>
                </div>

                <div class="card-body text-center">
                    <button id="browseFile" class="btn btn-primary">Browse File</button>
                    <div class="progress mt-3" style="height: 25px; display: none;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated"
                             role="progressbar" style="width: 0%; height: 100%">0%
                        </div>
                    </div>
                </div>

                <div class="card-footer p-4" style="display: none">
                    <img id="imagePreview" src="" style="width: 100%; display: none" alt="img"/>
                    <video id="videoPreview" controls style="width: 100%; display: none"></video>
                </div>
                <div id="uploadSuccess" class="alert alert-success mt-3" style="display: none;">
                    File uploaded successfully!
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    let browseFile = $('#browseFile');
    let progress = $('.progress');

    let resumable = new Resumable({
        target: "{{ route('upload.store') }}",
        query: {_token: "{{ csrf_token() }}"},
        fileType: ['png', 'jpg', 'jpeg', 'mp4', 'zip', 'pdf', 'docx', 'txt'],
        chunkSize: 2 * 1024 * 1024,
        headers: {
            'Accept': 'application/json'
        },
        testChunks: false,
        throttleProgressCallbacks: 1,
    });

    resumable.assignBrowse(browseFile[0]);

    resumable.on('fileAdded', function () {
        showProgress();
        resumable.upload();
    });

    resumable.on('fileProgress', function (file) {
        updateProgress(Math.floor(file.progress() * 100));
    });

    resumable.on('fileSuccess', function (file, response) {
        response = typeof response === 'string' ? JSON.parse(response) : response;

        if (response.mime_type.includes("image")) {
            $('#imagePreview').attr('src', response.path + '/' + response.name).show();
        }

        if (response.mime_type.includes("video")) {
            $('#videoPreview').attr('src', response.path + '/' + response.name).show();
        }

        $('.card-footer').show();
    });

    resumable.on('fileError', function () {
        alert('File uploading error.');
    });

    function showProgress() {
        progress.find('.progress-bar').css('width', '0%').html('0%').removeClass('bg-success');
        progress.show();
    }

    function updateProgress(value) {
        progress.find('.progress-bar').css('width', `${value}%`).html(`${value}%`);
        if (value === 100) {
            progress.find('.progress-bar').addClass('bg-success');
            showSuccessMessage('File uploaded successfully!');
            setTimeout(() => {
                progress.hide();
                progress.find('.progress-bar').removeClass('bg-success').css('width', '0%').html('0%');
            }, 1500);
        }
    }

    function showSuccessMessage(message) {
        $('#uploadSuccess').text(message).fadeIn();
        setTimeout(() => {
            $('#uploadSuccess').fadeOut();
        }, 4000);
    }
</script>


</body>
</html>
