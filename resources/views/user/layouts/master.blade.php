</html>
<!DOCTYPE html>
<html lang="en">
@include('user.layouts.header.index')

<body>
    
    @include('user.layouts.header.navbar')
    <main>
        @yield('user-content')
    </main>

    @include('user.layouts.footer.index')
</body>
</html>