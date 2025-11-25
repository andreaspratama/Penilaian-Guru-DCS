<div id="sidebar" class="active">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header">
                    <div class="d-flex justify-content-between">
                        <div class="logo">
                            <a href="index.html"><img src="{{url('./belakang/assets/images/logo/logo.png')}}" alt="Logo" srcset=""></a>
                        </div>
                        <div class="toggler">
                            <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-title">Menu</li>

                        <li class="sidebar-item active ">
                            <a href="index.html" class='sidebar-link'>
                                <i class="bi bi-grid-fill"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <li class="sidebar-item  has-sub">
                            <a href="#" class='sidebar-link'>
                                <i class="bi bi-stack"></i>
                                <span>Data Master</span>
                            </a>
                            <ul class="submenu ">
                                <li class="submenu-item ">
                                    <a href="{{route('unit.index')}}">Unit</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="{{route('guru.index')}}">Guru</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="{{route('siswa.index')}}">Siswa</a>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-item  has-sub">
                            <a href="#" class='sidebar-link'>
                                <i class="bi bi-question-circle"></i>
                                <span>Data Jawaban</span>
                            </a>
                            <ul class="submenu ">
                                <li class="submenu-item ">
                                    <a href="{{route('allResponse')}}">Semua</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="{{route('sortBySma')}}">Per Unit SMA</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="{{route('sortBySmp')}}">Per Unit SMP</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="{{route('sortByEle')}}">Per Unit Elementary</a>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </div>
                <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
            </div>
        </div>