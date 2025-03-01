{{-- <div>  
    <header>
        <div class="container">
            <a href="#" class="logo pull-left">
                <figure><img src="{{ asset('assets/demo-data/Logo1.png') }}" width="56" height="56" alt="/">
                </figure>
            </a>
            <p style="color: rgb(26, 164, 38);"></p>
            <nav>

                <ul class="pull-right pt-5">
                    <li><a href="/">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#services">Services</a></li>
                    <li><a href="#contact">Contact</a></li>
                    <li><a href="{{ route('login') }}">Login</a></li>
                </ul>
            </nav>

        </div>
    </header>
</div> --}}
<style>
  nav ul {
    list-style-type: none; 
    padding: 0;
    overflow: hidden;
}
nav ul li {
    display: inline; 
    margin: 0 15px; 
}
nav ul li a {
    color: rgb(26, 164, 38); 
    text-decoration: none; 
    text-align: center;
    font-size: 18px;
    padding: 14px 16px;
}

/* Default hover effect */
nav a:hover {
    background-color: #ddd;
    color: black;
}

/* Active link styling */
.nav-links li.active-link a {
    background-color: #ddd;
    color: black; 
    border-bottom: 2px solid rgb(26, 164, 38); 
}

/* Mobile Styles */
.hamburger {
    display: none;
    cursor: pointer;
}
.hamburger div {
    width: 25px;
    height: 3px;
    background-color: rgb(26, 164, 38);
    margin: 5px;
}

/* Responsive styles */
@media (max-width: 768px) {
    nav ul {
        display: none;
        flex-direction: column;
        width: 100%;
        z-index: 1000;
        background-color: rgb(26, 164, 38); 
        position: absolute;
        top: 80px; 
        left: 0;
        text-align: center; 
    }
    nav ul li {
        display: block;
        margin: 10px 0;
    }
    nav ul li a {
        color: black; 
        display: block;
        padding: 10px;
    }
    nav ul li a:hover {
        color: white; 
        background-color: rgba(0, 0, 0, 0.2); 
    }

    /* Ensure active link is styled properly in mobile mode */
    .nav-links li.active-link a {
        background-color: transparent !important; 
        color: white !important; 
        
    }

    .hamburger {
        margin: 20px;
        display: block;
    }
}

</style>
<div>  
    <header>
        <div class="container">
            <div class="nav-container">
                <div class="row justify-content-between mt-3">
                    <div class="col-auto">
                        <a href="#" class="logo">
                            <figure>
                                <img src="{{ asset('assets/demo-data/Logo1.png') }}" width="56" height="56" alt="/">
                            </figure>
                        </a>
                    </div>
                    <div class="col-auto">
                        <div class="hamburger" onclick="toggleMenu()">
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                        <nav>
                            <ul class="nav-links">
                                <li class="{{ request()->is('/') ? 'active-link' : '' }}"><a href="/">Home</a></li>
                                <li class="{{ request()->is('about') ? 'active-link' : '' }}"><a href="#about">About</a></li>
                                <li class="{{ request()->is('services') ? 'active-link' : '' }}"><a href="#services">Services</a></li>
                                <li class="{{ request()->is('contact') ? 'active-link' : '' }}"><a href="#contact">Contact</a></li>
                                <li class="{{ request()->is('login') ? 'active-link' : '' }}"><a href="{{ route('login') }}">Login</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>
</div>

   <script>
    function toggleMenu() {
        $('.nav-links').slideToggle(); // Adds a smooth sliding animation
    }
</script>

