<form method="POST" action="{{ route('admin.profile.update') }}">
    @csrf
    <input type="text" name="name" value="{{ old('name', $admin->name) }}" placeholder="Name">
    <input type="email" name="email" value="{{ old('email', $admin->email) }}" placeholder="Email">

    <input type="password" name="password" placeholder="New Password">
    <input type="password" name="password_confirmation" placeholder="Confirm Password">

    <button type="submit">Update Profile</button>
</form>
