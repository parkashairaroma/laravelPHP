<aside class="sidebar">
    <ul class="menu">
        <li><a href="{{ $basePath }}/admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ $basePath }}/" target="_blank"><i class="fa fa-eye"></i> View Site</a></li>
        <li><a><i class="fa fa-language"></i> Translations</a>
            <ul class="submenu">
            @if (in_array('manage_links', $authRoles))
                <li><a href="{{ $basePath }}/admin/links"><i class="fa fa-link"></i> Links</a></li> 
            @endif
            @if (in_array('manage_tags', $authRoles))
                <li><a href="{{ $basePath }}/admin/tags"><i class="fa fa-tag"></i> Tags</a></li> 
            @endif
            @if (in_array('manage_industries', $authRoles))
                <li><a href="{{ $basePath }}/admin/industries"><i class="fa fa-building"></i> Industries</a></li> 
            @endif
            @if (in_array('manage_pages', $authRoles))
                <li><a href="{{ $basePath }}/admin/pages"><i class="fa fa-file"></i> Pages</a></li> 
            @endif
            </ul>
        </li>
        @if (in_array('manage_banners', $authRoles))
            <li><a href="{{ $basePath }}/admin/banners"><i class="fa fa-square"></i> Banners</a></li>
        @endif
        @if (in_array('manage_blog', $authRoles))
            <li><a href="{{$basePath }}/admin/blog"><i class="fa fa-rss"></i> Blog</a></li> 
        @endif
        @if (in_array('manage_clients', $authRoles))
        <li>
            <a href="{{$basePath }}/admin/clients">
                <i class="fa fa-briefcase"></i>Clients
            </a>
        </li>
        @endif
        @if (in_array('manage_users', $authRoles))
        <li>
            <a href="{{$basePath }}/admin/users">
                <i class="fa fa-users"></i>Users
            </a>
        </li>
        @endif

        @if (in_array('manage_orders', $authRoles) || in_array('manage_products', $authRoles))
        <li>
            <a>
                <i class="fa fa-shopping-cart"></i>Store
            </a>
            <ul class="submenu">
                @if (in_array('manage_orders', $authRoles))
                <li>
                    <a href="{{ $basePath }}/admin/orders">
                        <i class="fa fa-check"></i>Orders
                    </a>
                </li>
                @endif
                @if (in_array('manage_products', $authRoles))
                <li>
                    <a href="{{$basePath }}/admin/products">
                        <i class="fa fa-cubes"></i>Products
                    </a>
                </li>
                @endif
                @if (in_array('manage_members', $authRoles))
                <li>
                    <a href="{{$basePath }}/admin/members">
                        <i class="fa fa-smile-o"></i>Members
                    </a>
                </li>
                @endif
                @if (in_array('manage_emails', $authRoles))
                <li>
                    <a href="{{$basePath }}/admin/emails">
                        <i class="fa fa-envelope"></i>Emails
                    </a>
                </li>
                @endif
                @if (in_array('manage_vouchers', $authRoles))
                <li>
                    <a href="{{$basePath }}/admin/vouchers">
                        <i class="fa fa-shopping-cart"></i>Vouchers
                    </a>
                </li>
                @endif
            </ul>
        </li>
        @endif 

    @if (in_array('admin_user', $authRoles) && $isBase)
        <li><a><i class="fa fa-cog"></i>Settings</a> 
            <ul class="submenu">
            @if (in_array('manage_websites', $authRoles))
                <li><a href="{{ $basePath }}/admin/websites"><i class="fa fa-rocket"></i> Websites</a></li>
            @endif
            @if (in_array('manage_users', $authRoles))
                <li><a href="{{ $basePath }}/admin/users"><i class="fa fa-users"></i> Users</a></li> 
            @endif
            </ul>
        </li>
        @endif
    </ul>
</aside>
