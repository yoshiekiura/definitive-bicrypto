<div class="mein-menu">
    <nav class="navbar navbar-expand-lg navbar-dark ">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img style="max-height: 50px" src="{{ getImage(imagePath()['logoIcon']['path'] . '/logo.png') }}"
                    class="logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation"><span
                    class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav text-light">
                    @if (!Request::is('**blog**'))
                        <li class="nav-item">
                            <a class="nav-link text-light" href="/trade/BTC/USDT">Trade</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" aria-current="page" href="#features">Features</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="#pricing">Pricing</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="#faq">FAQ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="/blog">Blog</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="#contact">Contact</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link text-light" href="/">Home</a>
                        </li>
                    @endif
                    {{-- <li class="nav-item">
                        <div class="language-select">
                            <select class="select-bar">
                                <option value="">EN</option>
                                <option value="">IN</option>
                                <option value="">BN</option>
                            </select>
                        </div>
                    </li> --}}
                    <li class="nav-item">
                        <a class="nav-link text-light btn @if (!Request::is('**blog**')) btn-primary @else btn-dark @endif text-white p-2"
                            href="/login">Start Now !</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>
