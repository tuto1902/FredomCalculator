<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="/" class="site_title">
                <i class="fa fa-paw"></i> <span>{{config('app.name')}}</span>
            </a>
        </div>

        <div class="clearfix"></div>

        <br />

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <ul class="nav side-menu">
                    <li>
                        <a href="/"><i class="fa fa-home"></i> Home </a>
                    </li>
                    <li>
                        <a><i class="fa fa-sitemap"></i> Multilevel Menu <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li>
                                <a href="#level1_1">Level One</a>
                            </li>
                            <li>
                                <a>Level One<span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li class="sub_menu">
                                        <a href="level2.html">Level Two</a>
                                    </li>
                                    <li>
                                        <a href="#level2_1">Level Two</a>
                                    </li>
                                    <li>
                                        <a href="#level2_2">Level Two</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#level1_2">Level One</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /sidebar menu -->
    </div>
</div>
