<!DOCTYPE html>
<html lang="en">
@include('admin.layouts.header.index')

<body>
    
    @include('admin.layouts.header.navbar')
    <main>
        @yield('admin-content')
    </main>

    @include('admin.layouts.footer.index')
</body>
</html>