<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Document')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <style>
        img {
            width: 100%;
        }
    </style>
</head>
<body>
    <header>
        @yield('header', '')
    </header>

    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="/logo.png" alt="Logo" class="rounded-pill" style="width:40px">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarScroll">
                <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/">Home</a>
                    </li>
                    
                    @if (Auth::check())
                        <li class="nav-item">
                            <a class="nav-link" href="/dashboard">Dashboard</a>
                        </li>
                    @endif

                    <li class="nav-item">
                        <a class="nav-link" href="/bookmarks">Bookmarks</a>
                    </li>
                    
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            News
                        </a>

                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/search?category=economy">Economy</a></li>
                            <li><a class="dropdown-item" href="/search?category=health">Health</a></li>
                            <li><a class="dropdown-item" href="/search?category=culinary">Culinary</a></li>
                            <li><a class="dropdown-item" href="/search?category=sports">Sports</a></li>
                            <li><a class="dropdown-item" href="/search?category=automotive">Automotive</a></li>
                            <li><a class="dropdown-item" href="/search?category=politics">Politics</a></li>
                            <li><a class="dropdown-item" href="/search?category=technology">Technology</a></li>
                        </ul>
                    </li>

                    @if (Auth::check() && Auth::user()->type == 'admin')
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Administrator
                            </a>

                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="/newsManagement">News Management</a></li>
                                <li><a class="dropdown-item" href="/userManagement">User Management</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="/reportManagement/comment">Comment Report Management</a></li>
                                <li><a class="dropdown-item" href="/reportManagement/news">News Report Management</a></li>
                                <li><a class="dropdown-item" href="/reportManagement/user">User Report Management</a></li>
                            </ul>
                        </li>
                    @endif

                    @if (Auth::check() && Auth::user()->type == 'editor')
                        <li class="nav-item">
                            <a class="nav-link" href="/newsManagement">News Management</a>
                        </li>
                    @endif
                </ul>

                <div class="d-flex flex-wrap p-1" style="gap: 1rem">
                    <form class="d-flex me-lg-5 flex-grow-1" role="search" action="/search">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search" id="search" value="{{ Request::get('search') }}">
                        <button class="btn btn-outline-success" type="submit"><i class="fas fa-search"></i></button>
                    </form>
    
                    @if (!Auth::check())
                        <a href="/login" class="btn btn-primary">Login</a>
                    @else
                        <form action="/logout" method="post">
                            @csrf
                            
                            <input type="submit" value="Logout" class="btn btn-primary">
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger alert-dismissible">
                <button class="btn-close" data-bs-dismiss="alert"></button>
                <strong>{{ $error }}</strong>
            </div>
        @endforeach
    @endif

    @session('success')
        <div class="alert alert-success alert-dismissible">
            <button class="btn-close" data-bs-dismiss="alert"></button>
            <strong>{{ $value }}</strong>
        </div>
    @endsession

    @session('error')
        <div class="alert alert-danger alert-dismissible">
            <button class="btn-close" data-bs-dismiss="alert"></button>
            <strong>{{ $value }}</strong>
        </div>
    @endsession

    <main class="container-fluid my-3 px-5 py-3" style="min-height: 50vh">
        @yield('main', '')
    </main>

    <footer class="d-flex container-fluid flex-wrap justify-content-center bg-dark text-bg-dark">
        <div class="p-4 flex-grow-1 d-flex flex-column align-items-center">
            <!-- <h2 class="text-center">Logo</h2> -->

            <img src="/logo.png" alt="logo" style="max-width: 128px; width: 100%;">

            <h5 class="mt-3">News Portal</h5>

            <p>Copyright &copy; 2024 PT Winnicode Garuda Teknologi</p>
        </div>

        <div class="p-4 flex-grow-1">
            <h4 class="mb-4">Links</h4>

            <div class="d-flex justify-content-between">
                <div>
                    <a href="/" class="nav-link">Home</a>
                    <a class="nav-link" href="/search?category=economy">Economy</a>
                    <a class="nav-link" href="/search?category=health">Health</a>
                    <a class="nav-link" href="/search?category=culinary">Culinary</a>
                    <a class="nav-link" href="/search?category=sports">Sports</a>
                    <a class="nav-link" href="/search?category=automotive">Automotive</a>
                    <a class="nav-link" href="/search?category=politics">Politics</a>
                    <a class="nav-link" href="/search?category=technology">Technology</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>