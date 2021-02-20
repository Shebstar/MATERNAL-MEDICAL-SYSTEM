<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>admin layout</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>
<body>
    <ul class="nav nav-pills">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="{{ route('admin_template') }}">Appointments made</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('admin_template') }}">Reports</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('admin_template') }}">users</a>
        </li>
        {{-- <li class="nav-item">
          <a class="nav-link " href="{{ route('login') }}" tabindex="-1" aria-disabled="true">log out</a>
        </li> --}}
        <div class="">
        <form method="POST" action="{{ route('logout') }}">
          @csrf

          <x-jet-dropdown-link href="{{ route('logout') }}"
                              onclick="event.preventDefault();
                                          this.closest('form').submit();">
              {{ __('Logout') }}
          </x-jet-dropdown-link>
        </div>
      </form>
      </ul>
      
      <div class="container">
          @yield('content')
      </div>
    

</body>
</html>