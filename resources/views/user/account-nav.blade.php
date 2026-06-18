<ul class="account-nav">
    <li><a href="{{ route('user.index') }} " class="menu-link menu-link_us-s">Панель управления</a></li>
    <li><a href="{{ route('user.orders') }}" class="menu-link menu-link_us-s">Заказы</a></li>
    <li><a href="{{route('user.addresses')}}" class="menu-link menu-link_us-s">Адреса</a></li>
    <li><a href="{{ route('wishlist.index') }}" class="menu-link menu-link_us-s">Избранное</a></li>
    <li>
    <form action="{{ route('logout') }}" method="post" id="logout-form">
        @csrf
        <a href="{{ route('logout') }}" class="menu-link menu-link_us-s" onclick="event.preventDefault();document.getElementById('logout-form').submit()" >Выход</a>
    </form>
    </li>
</ul>
