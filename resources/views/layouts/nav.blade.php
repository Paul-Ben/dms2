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
    list-style-type: none; /* Remove bullet points */
    padding: 0;
    overflow: hidden;
}
nav ul li {
    display: inline; /* Align items in a row */
    margin: 0 15px; /* Spacing between links */
    
}
nav ul li a {
    color: rgb(26, 164, 38); /* White text for links */
    text-decoration: none; /* Remove underline */
    text-align: center;
    font-size: 18px;
    padding: 14px 16px;
}
nav a:hover {
    background-color: #ddd;
    color: black;
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
                 <nav>
                    <ul class="nav-links">
                        <li><a href="/">Home</a></li>
                        <li><a href="#about">About</a></li>
                        <li><a href="#services">Services</a></li>
                        <li><a href="#contact">Contact</a></li>
                        <li><a href="{{ route('login') }}">Login</a></li>
                    </ul>
                </nav>
               </div>
               
                </div>
               
            </div>
        </div>
    </header>
</div>
