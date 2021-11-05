                            
                    @inject('menus','App\Http\Controllers\Settings\MenuController')
                    @php
                        $cntr = 0;
                    @endphp
                    <ul class="widget widget-menu unstyled">
                    @foreach($menus->menu() as $menu)                        
                        @php
                            $cntr++;
                        @endphp
                        @if(count($menus->menu($menu->id)))
                            <li><a class="collapsed" data-toggle="collapse" href="#togglePages{{$cntr}}"><i class="menu-icon icon-cog">
                                </i><i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right">
                                </i>{{$menu->name}}</a>  
                                <ul id="togglePages{{$cntr}}" class="collapse unstyled">                          
                            @foreach($menus->menu($menu->id) as $child)
                                <li><a href="{{ route($child->url) }}"><i class="icon-inbox"></i>{{$child->name}}</a></li>
                            @endforeach
                                </ul>
                            </li>
                        @else
                            <li class="active"><a  href="{{ route($menu->url) }}"><i class="menu-icon icon-dashboard"></i>{{$menu->name}}
                            </a></li>
                        @endif
                    @endforeach
                    </ul>        

                            <!--/.widget-nav-->                      

                            <ul class="widget widget-menu unstyled">
                                <li><a href="{{ route('logout') }}"><i class="menu-icon icon-signout"></i>Logout </a></li>
                            </ul>

