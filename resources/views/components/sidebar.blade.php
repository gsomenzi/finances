<div id="app-sidebar">
    <div id="app-sidebar-menu">
        <a href="/" class="app-sidebar-item {{ Route::currentRouteName() === "web.home" ? "active" : "" }}">
            <span uk-icon="home"></span>
            <span class="app-sidebar-item-title">Home</span>
        </a>
        <a href="/contas" class="app-sidebar-item {{ Route::currentRouteName() === "web.financial-account.list" ? "active" : "" }}">
            <span uk-icon="folder"></span>
            <span class="app-sidebar-item-title">Contas</span>
        </a>
        <a href="/transacoes" class="app-sidebar-item {{ Route::currentRouteName() === "web.financial-transaction.list" ? "active" : "" }}">
            <span uk-icon="list"></span>
            <span class="app-sidebar-item-title">Transações</span>
        </a>
        <a href="/" class="app-sidebar-item">
            <span uk-icon="credit-card"></span>
            <span class="app-sidebar-item-title">Cartões de crédito</span>
        </a>
    </div>
</div>