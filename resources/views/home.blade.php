@extends('layouts.app')

@section('content')

<style>
    .page-content {
    /* The image used */

    @if (Auth::user()->isColor == 1)
    background:
        /* top, transparent black, faked with gradient */

        linear-gradient(#0009,
            #0009),
        /* bottom, image */

            url("{{ Auth::user()->background }}");
    @endif

    @if (Auth::user()->isColor == 2)
        color:{{ Auth::user()->color }}
    @endif

    /* Full height */


    /* Create the parallax scrolling effect */
    background-attachment: fixed;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
}
</style>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>
                        {{ $error }}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session()->get('message'))
        <div class="alert alert-success" role="alert">
            <strong>Success: </strong>{{ session()->get('message') }}
        </div>
    @endif
    <svg style="display:none;">

        <symbol id="down" viewBox="0 0 16 16">
            <polygon points="3.81 4.38 8 8.57 12.19 4.38 13.71 5.91 8 11.62 2.29 5.91 3.81 4.38" />
        </symbol>
        <symbol id="users" viewBox="0 0 16 16">
            <path
                d="M8,0a8,8,0,1,0,8,8A8,8,0,0,0,8,0ZM8,15a7,7,0,0,1-5.19-2.32,2.71,2.71,0,0,1,1.7-1,13.11,13.11,0,0,0,1.29-.28,2.32,2.32,0,0,0,.94-.34,1.17,1.17,0,0,0-.27-.7h0A3.61,3.61,0,0,1,5.15,7.49,3.18,3.18,0,0,1,8,4.07a3.18,3.18,0,0,1,2.86,3.42,3.6,3.6,0,0,1-1.32,2.88h0a1.13,1.13,0,0,0-.27.69,2.68,2.68,0,0,0,.93.31,10.81,10.81,0,0,0,1.28.23,2.63,2.63,0,0,1,1.78,1A7,7,0,0,1,8,15Z" />
        </symbol>
        <symbol id="collection" viewBox="0 0 16 16">
            <rect width="7" height="7" />
            <rect y="9" width="7" height="7" />
            <rect x="9" width="7" height="7" />
            <rect x="9" y="9" width="7" height="7" />
        </symbol>
        <symbol id="charts" viewBox="0 0 16 16">
            <polygon
                points="0.64 7.38 -0.02 6.63 2.55 4.38 4.57 5.93 9.25 0.78 12.97 4.37 15.37 2.31 16.02 3.07 12.94 5.72 9.29 2.21 4.69 7.29 2.59 5.67 0.64 7.38" />
            <rect y="9" width="2" height="7" />
            <rect x="12" y="8" width="2" height="8" />
            <rect x="8" y="6" width="2" height="10" />
            <rect x="4" y="11" width="2" height="5" />
        </symbol>
        <symbol id="comments" viewBox="0 0 16 16">
            <path d="M0,16.13V2H15V13H5.24ZM1,3V14.37L5,12h9V3Z" />
            <rect x="3" y="5" width="9" height="1" />
            <rect x="3" y="7" width="7" height="1" />
            <rect x="3" y="9" width="5" height="1" />
        </symbol>
        <symbol id="pages" viewBox="0 0 16 16">
            <rect x="4" width="12" height="12" transform="translate(20 12) rotate(-180)" />
            <polygon points="2 14 2 2 0 2 0 14 0 16 2 16 14 16 14 14 2 14" />
        </symbol>
        <symbol id="appearance" viewBox="0 0 16 16">
            <path
                d="M3,0V7A2,2,0,0,0,5,9H6v5a2,2,0,0,0,4,0V9h1a2,2,0,0,0,2-2V0Zm9,7a1,1,0,0,1-1,1H9v6a1,1,0,0,1-2,0V8H5A1,1,0,0,1,4,7V6h8ZM4,5V1H6V4H7V1H9V4h1V1h2V5Z" />
        </symbol>
        <symbol id="trends" viewBox="0 0 16 16">
            <polygon
                points="0.64 11.85 -0.02 11.1 2.55 8.85 4.57 10.4 9.25 5.25 12.97 8.84 15.37 6.79 16.02 7.54 12.94 10.2 9.29 6.68 4.69 11.76 2.59 10.14 0.64 11.85" />
        </symbol>
        <symbol id="settings" viewBox="0 0 16 16">
            <rect x="9.78" y="5.34" width="1" height="7.97" />
            <polygon points="7.79 6.07 10.28 1.75 12.77 6.07 7.79 6.07" />
            <rect x="4.16" y="1.75" width="1" height="7.97" />
            <polygon points="7.15 8.99 4.66 13.31 2.16 8.99 7.15 8.99" />
            <rect x="1.28" width="1" height="4.97" />
            <polygon points="3.28 4.53 1.78 7.13 0.28 4.53 3.28 4.53" />
            <rect x="12.84" y="11.03" width="1" height="4.97" />
            <polygon points="11.85 11.47 13.34 8.88 14.84 11.47 11.85 11.47" />
        </symbol>
        <symbol id="options" viewBox="0 0 16 16">
            <path d="M8,11a3,3,0,1,1,3-3A3,3,0,0,1,8,11ZM8,6a2,2,0,1,0,2,2A2,2,0,0,0,8,6Z" />
            <path
                d="M8.5,16h-1A1.5,1.5,0,0,1,6,14.5v-.85a5.91,5.91,0,0,1-.58-.24l-.6.6A1.54,1.54,0,0,1,2.7,14L2,13.3a1.5,1.5,0,0,1,0-2.12l.6-.6A5.91,5.91,0,0,1,2.35,10H1.5A1.5,1.5,0,0,1,0,8.5v-1A1.5,1.5,0,0,1,1.5,6h.85a5.91,5.91,0,0,1,.24-.58L2,4.82A1.5,1.5,0,0,1,2,2.7L2.7,2A1.54,1.54,0,0,1,4.82,2l.6.6A5.91,5.91,0,0,1,6,2.35V1.5A1.5,1.5,0,0,1,7.5,0h1A1.5,1.5,0,0,1,10,1.5v.85a5.91,5.91,0,0,1,.58.24l.6-.6A1.54,1.54,0,0,1,13.3,2L14,2.7a1.5,1.5,0,0,1,0,2.12l-.6.6a5.91,5.91,0,0,1,.24.58h.85A1.5,1.5,0,0,1,16,7.5v1A1.5,1.5,0,0,1,14.5,10h-.85a5.91,5.91,0,0,1-.24.58l.6.6a1.5,1.5,0,0,1,0,2.12L13.3,14a1.54,1.54,0,0,1-2.12,0l-.6-.6a5.91,5.91,0,0,1-.58.24v.85A1.5,1.5,0,0,1,8.5,16ZM5.23,12.18l.33.18a4.94,4.94,0,0,0,1.07.44l.36.1V14.5a.5.5,0,0,0,.5.5h1a.5.5,0,0,0,.5-.5V12.91l.36-.1a4.94,4.94,0,0,0,1.07-.44l.33-.18,1.12,1.12a.51.51,0,0,0,.71,0l.71-.71a.5.5,0,0,0,0-.71l-1.12-1.12.18-.33a4.94,4.94,0,0,0,.44-1.07l.1-.36H14.5a.5.5,0,0,0,.5-.5v-1a.5.5,0,0,0-.5-.5H12.91l-.1-.36a4.94,4.94,0,0,0-.44-1.07l-.18-.33L13.3,4.11a.5.5,0,0,0,0-.71L12.6,2.7a.51.51,0,0,0-.71,0L10.77,3.82l-.33-.18a4.94,4.94,0,0,0-1.07-.44L9,3.09V1.5A.5.5,0,0,0,8.5,1h-1a.5.5,0,0,0-.5.5V3.09l-.36.1a4.94,4.94,0,0,0-1.07.44l-.33.18L4.11,2.7a.51.51,0,0,0-.71,0L2.7,3.4a.5.5,0,0,0,0,.71L3.82,5.23l-.18.33a4.94,4.94,0,0,0-.44,1.07L3.09,7H1.5a.5.5,0,0,0-.5.5v1a.5.5,0,0,0,.5.5H3.09l.1.36a4.94,4.94,0,0,0,.44,1.07l.18.33L2.7,11.89a.5.5,0,0,0,0,.71l.71.71a.51.51,0,0,0,.71,0Z" />
        </symbol>
        <symbol id="collapse" viewBox="0 0 16 16">
            <polygon points="11.62 3.81 7.43 8 11.62 12.19 10.09 13.71 4.38 8 10.09 2.29 11.62 3.81" />
        </symbol>
        <symbol id="search" viewBox="0 0 16 16">
            <path
                d="M6.57,1A5.57,5.57,0,1,1,1,6.57,5.57,5.57,0,0,1,6.57,1m0-1a6.57,6.57,0,1,0,6.57,6.57A6.57,6.57,0,0,0,6.57,0Z" />
            <rect x="11.84" y="9.87" width="2" height="5.93"
                transform="translate(-5.32 12.84) rotate(-45)" />
        </symbol>
    </svg>

    <header class="page-header">
        <nav>
            <a href="{{ route('home') }}" aria-label="Sawtru logo" class="logo">
                <img src="{{ URL::asset('images/logo.svg') }}">
            </a>
            <a href="{{ route('home') }}" aria-label="Sawtru logo" class="logo-collapsed">
                <img src="{{ URL::asset('images/logo-short.svg') }}">
            </a>
            <button class="toggle-mob-menu" aria-expanded="false" aria-label="open menu">
                <svg width="20" height="20" aria-hidden="true">
                    <use xlink:href="#down"></use>
                </svg>
            </button>
            <ul class="admin-menu">
                <li>
                    <a href="/dashboard" class="{{ request()->is('dashboard') ? 'active' : '' }}">
                        <span style="font-size:22px;padding-left:1px;" class="fa fa-home col-2"></span>
                        <span style="padding-left:3px;">Home</span>
                    </a>
                </li>
                @can('list-users')
                <li>
                    <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <span style="font-size:22px;padding-left:2px;" class="fa fa-plus col-2"></span>
                        <span style="padding-left:3px;">Manage Users</span>
                    </a>
                </li>
                 @endcan
                <li>
                    <a href="{{ route('profile') }}" class="{{ request()->routeIs('profile') ? 'active' : '' }}">
                        <svg>
                            <use xlink:href="#users"></use>
                        </svg>
                        <span>Profile</span>
                    </a>
                </li>
                <li>
                    @canany(['list-all-project', 'list-self-project', 'list-project'])
                        @can('create-project')
                            <li>
                                <a href="{{ route('projects.create') }}" class="{{ request()->routeIs('projects.create') ? 'active' : '' }}">
                                    <svg>
                                        <use xlink:href="#trends"></use>
                                    </svg>
                                    <span>Add New Project</span>
                                </a>
                            </li>
                        @endcan
                        <li>
                            <a href="{{ route('projects.index') }}" class="{{ (request()->routeIs('projects.index') || request()->routeIs('projects.show') || request()->routeIs('projects.edit')) ? 'active' : '' }}">
                                <svg>
                                    <use xlink:href="#collection"></use>
                                </svg>
                                <span>All Projects</span>
                            </a>
                        </li>
                    </li>
                @endcanany
                @canany(['list-self-purchases', 'list-purchases', 'list-project'])
                        <li>
                            <a href="{{ route('purchases.index') }}" class="{{ request()->routeIs('purchases.*') ? 'active' : '' }}">
                                <svg>
                                    <use xlink:href="#collection"></use>
                                </svg>
                                <span>All Purchases</span>
                            </a>
                        </li>
                @endcanany
                    {{--
                <li>
                    <a href="#0">
                        <svg>
                            <use xlink:href="#comments"></use>
                        </svg>
                        <span>Comments</span>
                    </a>
                </li>
                <li>
                    <a href="#0">
                        <svg>
                            <use xlink:href="#appearance"></use>
                        </svg>
                        <span>Appearance</span>
                    </a>
                </li>--}}
                <li class="menu-heading">
                    <h3>Settings</h3>
                </li>
                <li>
                    <a href="{{ route('settings.index') }}" class="{{ (request()->routeIs('settings.*') || request()->routeIs('roles.*')) ? 'active' : '' }}">
                        <svg>
                            <use xlink:href="#options"></use>
                        </svg>
                        <span>Settings</span>
                    </a>
                </li>
                {{--<li>
                    <a href="#0">
                        <svg>
                            <use xlink:href="#charts"></use>
                        </svg>
                        <span>Charts</span>
                    </a>
                </li>--}}
                <li>
                    <div class="switch">
                        <input type="checkbox" id="mode" checked>
                        <label for="mode">
                            <span></span>
                            <span>Dark</span>
                        </label>
                    </div>
                    <button class="collapse-btn" aria-expanded="true" aria-label="collapse menu">
                        <svg aria-hidden="true">
                            <use xlink:href="#collapse"></use>
                        </svg>
                        <span>Collapse</span>
                    </button>
                </li>
            </ul>
        </nav>
    </header>
    <section class="page-content">
        <section class="search-and-user">
            <div class="admin-profile">
                <span style="display:flex" class="greeting">Hello&nbsp;
                    @guest
                        @if (Route::has('login'))
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        @endif
                        @if (Route::has('register'))
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        @endif
                    @else
                        <div class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    @endguest
                </span>
                <div class="notifications">
                    <span id="badge" class="badge">0</span>
                    <svg>
                        <use xlink:href="#users"></use>
                    </svg>
                </div>
                <div id='notification'>
                    <div class="noti">
                        @yield('msg')
                    </div>
                </div>

                <div>
                    <div onclick="window.location.replace('{{ route('settings.index') }}')" title="Settings"
                        class="fa fa-cog"></div>
                </div>

                <div onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();"
                    title="Logoff" class="fa fa-power-off"></div>
            </div>

        </section>
        <section class="grid">
            <article>

                @yield('articles')

            </article>
        </section>
        <footer class="page-footer">
            <span>made by </span>
            <a href="https://sawtrudev.com/" target="_blank">
                <img width="24" height="24" src="{{ URL::asset('images/logo-short.svg') }}" alt="Sawtru logo">
            </a>
        </footer>
    </section>

    {{-- Shared "view details" modal: filled from a show page fetched over
         AJAX, so individual pages don't need their own modal markup. --}}
    <div id="sawtruViewModal" class="sawtru-modal" hidden>
        <div class="sawtru-modal__backdrop" data-modal-close></div>
        <div class="sawtru-modal__dialog sawtru-modal__dialog--view" role="dialog" aria-modal="true">
            <div class="sawtru-modal__head">
                <h3 id="sawtruViewModalTitle">Details</h3>
                <button type="button" class="sawtru-modal__x" data-modal-close aria-label="Close">&times;</button>
            </div>
            <div class="sawtru-modal__body" id="sawtruViewModalBody">
                <div class="sawtru-modal__loading">Loading&hellip;</div>
            </div>
        </div>
    </div>

    {{-- Shared "confirm delete" modal, used in place of window.confirm(). --}}
    <div id="sawtruConfirmModal" class="sawtru-modal" hidden>
        <div class="sawtru-modal__backdrop" data-modal-close></div>
        <div class="sawtru-modal__dialog sawtru-modal__dialog--confirm" role="alertdialog" aria-modal="true">
            <div class="sawtru-modal__head">
                <h3>Delete</h3>
                <button type="button" class="sawtru-modal__x" data-modal-close aria-label="Close">&times;</button>
            </div>
            <div class="sawtru-modal__body">
                <p class="sawtru-modal__item" id="sawtruConfirmModalItem"></p>
                <p id="sawtruConfirmModalMessage">Are you sure you want to delete this? This cannot be undone.</p>
            </div>
            <div class="sawtru-modal__foot">
                <button type="button" class="btn sawtru-btn-cancel" data-modal-close>Cancel</button>
                <button type="button" class="btn sawtru-btn-danger" id="sawtruConfirmModalConfirm">Delete</button>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        const html1 = document.documentElement;
        const body1 = document.body;
        const menuLinks1 = document.querySelectorAll(".admin-menu a");
        const collapseBtn1 = document.querySelector(".admin-menu .collapse-btn");
        const toggleMobileMenu1 = document.querySelector(".toggle-mob-menu");
        const switchInput1 = document.querySelector(".switch input");
        const switchLabel1 = document.querySelector(".switch label");
        const switchLabelText1 = switchLabel1.querySelector("span:last-child");
        const collapsedClass1 = "collapsed";
        const lightModeClass1 = "light-mode";

        /*TOGGLE HEADER STATE*/
        // Restore the saved collapse state so it persists across page loads.
        if (localStorage.getItem("sidebar-collapsed") === "true") {
            body1.classList.add(collapsedClass1);
            collapseBtn1.setAttribute("aria-expanded", "false");
            collapseBtn1.setAttribute("aria-label", "expand menu");
        }

        collapseBtn1.addEventListener("click", function() {
            body1.classList.toggle(collapsedClass1);
            var isCollapsed = body1.classList.contains(collapsedClass1);
            localStorage.setItem("sidebar-collapsed", isCollapsed ? "true" : "false");
            this.getAttribute("aria-expanded") == "true" ?
                this.setAttribute("aria-expanded", "false") :
                this.setAttribute("aria-expanded", "true");
            this.getAttribute("aria-label") == "collapse menu" ?
                this.setAttribute("aria-label", "expand menu") :
                this.setAttribute("aria-label", "collapse menu");
        });

        /*TOGGLE MOBILE MENU*/
        toggleMobileMenu1.addEventListener("click", function() {
            body1.classList.toggle("mob-menu-opened");
            this.getAttribute("aria-expanded") == "true" ?
                this.setAttribute("aria-expanded", "false") :
                this.setAttribute("aria-expanded", "true");
            this.getAttribute("aria-label") == "open menu" ?
                this.setAttribute("aria-label", "close menu") :
                this.setAttribute("aria-label", "open menu");
        });

        /*SHOW TOOLTIP ON MENU LINK HOVER*/
        for (const link of menuLinks1) {
            link.addEventListener("mouseenter", function() {
                if (
                    body1.classList.contains(collapsedClass1) &&
                    window.matchMedia("(min-width: 768px)").matches
                ) {
                    const tooltip = this.querySelector("span").textContent;
                    this.setAttribute("title", tooltip);
                } else {
                    this.removeAttribute("title");
                }
            });
        }



        /*TOGGLE LIGHT/DARK MODE*/
        if (localStorage.getItem("dark-mode") === "false") {
            html1.classList.add(lightModeClass1);
            switchInput1.checked = false;
            switchLabelText1.textContent = "Light";
        }

        switchInput1.addEventListener("input", function() {
            html1.classList.toggle(lightModeClass1);
            if (html1.classList.contains(lightModeClass1)) {
                switchLabelText1.textContent = "Light";
                localStorage.setItem("dark-mode", "false");
            } else {
                switchLabelText1.textContent = "Dark";
                localStorage.setItem("dark-mode", "true");
            }
        });

        var rjs_cursor = document.getElementById("rjs_cursor"); //Getting the cursor
        var body = document.querySelector("body"); //Get the body element

        //Functions for showing and hiding the cursor
        //They are referenced the
        function rjs_show_cursor(e) { //Function to show/hide the cursor
            if (rjs_cursor.classList.contains('rjs_cursor_hidden')) {
                rjs_cursor.classList.remove('rjs_cursor_hidden');
            }
            rjs_cursor.classList.add('rjs_cursor_visible');
        }

        function rjs_hide_cursor(e) {
            if (rjs_cursor.classList.contains('rjs_cursor_visible')) {
                rjs_cursor.classList.remove('rjs_cursor_visible');
            }
            rjs_cursor.classList.add('rjs_cursor_hidden');
        }


        function rjs_mousemove(e) { //Function to correctly position the cursor
            rjs_show_cursor(); //Toggle show/hide

            var rjs_cursor_width = rjs_cursor.offsetWidth * 0.5;
            var rjs_cursor_height = rjs_cursor.offsetHeight * 0.5;

            var rjs_cursor_x = e.clientX - rjs_cursor_width; //x-coordinate
            var rjs_cursor_y = e.clientY - rjs_cursor_height; //y-coordinate
            var rjs_cursor_pos = `translate(${rjs_cursor_x}px, ${rjs_cursor_y}px)`;
            rjs_cursor.style.transform = rjs_cursor_pos;
        }


        //Eventlisteners
        window.addEventListener('mousemove', rjs_mousemove); //Attach an event listener
        body.addEventListener('mouseleave', rjs_hide_cursor);



        //Hover behaviour
        function rjs_hover_cursor(e) {
            rjs_cursor.classList.add('rjs_cursor_hover');
        }

        function rjs_unhover_cursor(e) {
            rjs_cursor.classList.remove('rjs_cursor_hover');
        }


        document.querySelectorAll('a').forEach(item => {
            item.addEventListener('mouseover', rjs_hover_cursor);
            item.addEventListener('mouseleave', rjs_unhover_cursor);
        })

        document.querySelectorAll('input').forEach(item => { //Input tags
            item.addEventListener('mouseover', rjs_hover_cursor);
            item.addEventListener('mouseleave', rjs_unhover_cursor);
        })

        document.querySelectorAll('button').forEach(item => { //Input tags
            item.addEventListener('mouseover', rjs_hover_cursor);
            item.addEventListener('mouseleave', rjs_unhover_cursor);
        })

        document.querySelectorAll('.mycustomclass').forEach(item => { //A custom class
            item.addEventListener('mouseover', rjs_hover_cursor);
            item.addEventListener('mouseleave', rjs_unhover_cursor);
        })
    </script>

    {{-- Shared modal controller: "view details" (fetches a show page and
         injects its content) and "confirm delete" (replaces confirm()). --}}
    <script>
        window.Sawtru = (function () {
            var viewModal = document.getElementById('sawtruViewModal');
            var viewTitle = document.getElementById('sawtruViewModalTitle');
            var viewBody = document.getElementById('sawtruViewModalBody');
            var confirmModal = document.getElementById('sawtruConfirmModal');
            var confirmItem = document.getElementById('sawtruConfirmModalItem');
            var confirmMsg = document.getElementById('sawtruConfirmModalMessage');
            var confirmBtn = document.getElementById('sawtruConfirmModalConfirm');
            var pendingConfirm = null;

            function open(modal) {
                modal.hidden = false;
                document.body.classList.add('sawtru-modal-open');
            }

            function close(modal) {
                modal.hidden = true;
                document.body.classList.remove('sawtru-modal-open');
            }

            function closeAll() {
                close(viewModal);
                close(confirmModal);
                pendingConfirm = null;
            }

            document.querySelectorAll('[data-modal-close]').forEach(function (el) {
                el.addEventListener('click', closeAll);
            });
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') closeAll();
            });

            function viewInModal(url, title) {
                viewTitle.textContent = title || 'Details';
                viewBody.innerHTML = '<div class="sawtru-modal__loading">Loading&hellip;</div>';
                open(viewModal);
                fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(function (res) { return res.text(); })
                    .then(function (html) {
                        var doc = new DOMParser().parseFromString(html, 'text/html');
                        var article = doc.querySelector('.page-content .grid > article') || doc.querySelector('article');
                        if (!article) {
                            viewBody.innerHTML = '<p>Could not load details.</p>';
                            return;
                        }
                        var head = article.querySelector('.content-head');
                        if (head) head.remove();
                        viewBody.innerHTML = article.innerHTML;
                    })
                    .catch(function () {
                        viewBody.innerHTML = '<p>Could not load details.</p>';
                    });
            }

            function confirmDelete(label, onConfirm, message) {
                confirmItem.textContent = label || '';
                confirmMsg.textContent = message || 'Are you sure you want to delete this? This cannot be undone.';
                pendingConfirm = onConfirm;
                open(confirmModal);
            }

            confirmBtn.addEventListener('click', function () {
                var fn = pendingConfirm;
                closeAll();
                if (typeof fn === 'function') fn();
            });

            return { viewInModal: viewInModal, confirmDelete: confirmDelete };
        })();
    </script>
@endsection
