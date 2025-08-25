<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>403 Forbidden</title>
    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
        crossorigin="anonymous" />
</head>

<body class="bg-body-tertiary">

    <main class="min-vh-100 d-flex align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-10 col-lg-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4 p-md-5 text-center">
                            <div class="display-1 fw-bold">403</div>
                            <h1 class="h3 mt-3">Forbidden</h1>
                            <p class="text-secondary mt-2">
                                You don’t have permission to access this page.<br />
                                If you believe this is an error, please contact the administrator.
                            </p>

                            <div class="d-flex gap-2 justify-content-center mt-3">
                                <a href="{{ route('user.pages.login') }}" class="btn btn-primary">Go Home</a>
                                <button type="button" class="btn btn-outline-secondary" onclick="history.back()">Go Back</button>
                            </div>

                            <hr class="my-4" />
                            <div class="small text-secondary">
                                Error Code: <span class="fw-semibold">A403</span>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-3">
                        <span class="text-secondary small">© <span id="year"></span> Your Company</span>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        document.getElementById('year').textContent = new Date().getFullYear();
    </script>
    <!-- Bootstrap JS (optional, for bundle utilities) -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>