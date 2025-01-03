<header class="bg-dark text-white">
  <div class="container">
    <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
      <a href="/" class="d-flex align-items-center m-0 text-white text-decoration-none">
        <img src="{{ asset('images/crm-logo.png') }}" alt="CRM Logo" width="80" height="60" class="me-2">
      </a>

      @auth
        @if (auth()->user()->is_active)
          <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
            <li><a href="{{ route('chatbots.index') }}" class="nav-link px-2 text-white">Chatbot</a></li>
            <li><a href="{{ route('chatbot-schedules.index') }}" class="nav-link px-2 text-white">Schedule</a></li>
            <li><a href="{{ route('customers.index') }}" class="nav-link px-2 text-white">Customer</a></li>
            <li><a href="{{ route('logistics.index') }}" class="nav-link px-2 text-white">Logistic</a></li>
            <li><a href="{{ route('awbs.index') }}" class="nav-link px-2 text-white">Awb</a></li>
            <li><a href="{{ route('orders.index') }}" class="nav-link px-2 text-white">Order</a></li>
          </ul>
        @endif
      @endauth

      <div class="ms-auto">
        @auth
          @if (auth()->user()->is_active)
            {{auth()->user()->username}}&nbsp;&nbsp;&nbsp;
          @endif
          <a href="{{ route('logout.perform') }}" class="btn btn-outline-light me-2">Logout</a>
        @endauth
      </div>

      @guest
        <div class="ms-auto">
          <a href="{{ route('login.perform') }}" class="btn btn-outline-light me-2">Login</a>
          <a href="{{ route('register.perform') }}" class="btn btn-warning">Sign-up</a>
        </div>
      @endguest
    </div>
  </div>
</header>