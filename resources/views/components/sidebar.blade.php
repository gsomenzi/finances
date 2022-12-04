<div id="app-sidebar">
    <div id="app-sidebar-menu">
        <a href="/" class="app-sidebar-item {{ Route::currentRouteName() === "web.home" ? "active" : "" }}">
            <span uk-icon="home"></span>
            <span class="app-sidebar-item-title">Home</span>
        </a>
        <a href="{{route("web.financial-account.listView")}}" class="app-sidebar-item {{ Route::currentRouteName() === "web.financial-account.listView" ? "active" : "" }}">
            <span uk-icon="folder"></span>
            <span class="app-sidebar-item-title">Contas</span>
        </a>
        <a href="/transacoes" class="app-sidebar-item {{ Route::currentRouteName() === "web.financial-transaction.list" ? "active" : "" }}">
            <span uk-icon="list"></span>
            <span class="app-sidebar-item-title">Lançamentos</span>
        </a>
        <a href="/" class="app-sidebar-item">
            <span uk-icon="credit-card"></span>
            <span class="app-sidebar-item-title">Cartões de crédito</span>
        </a>
        <a href="{{route("web.auth.logout")}}" class="app-sidebar-item confirmable" data-confirm-text="Você tem certeza que deseja sair?">
            <span uk-icon="sign-out"></span>
            <span class="app-sidebar-item-title">Sair</span>
        </a>
    </div>
</div>