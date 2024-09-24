<div class="navigation">

@php  $menus = DB::table('menus')->where('isActive',1)->where('menu_category_id',1)->get(); @endphp
                        <div class="d-flex flex-column flex-shrink-0 p-0  w-100">

                            <ul class="nav nav-pills flex-column mb-auto">
                                @foreach($menus as $key => $menu)

                                
                                @php  $submenus = DB::table('menus')->where('isActive',1)->where('menu_category_id',2)->where('parent_id',$menu->id)->get(); @endphp

                                <li class="nav-item {{!$submenus->isEmpty() ? 'dropdown ': '' }}">
                                    <a href="{{$menu->slug}}" class="nav-link {{!$submenus->isEmpty() ? 'dropdown-toggle ': '' }}"   id="navbarDarkDropdownMenuLink1{{$key}}"  role="{{!$submenus->isEmpty() ? 'button': '' }}" data-bs-toggle="{{!$submenus->isEmpty() ? 'dropdown': '' }}" aria-expanded="false">
                                        {{$menu->title}}
                                    </a>
                                    @if(!$submenus->isEmpty())
                                    <ul class="dropdown-menu" aria-labelledby="navbarDarkDropdownMenuLink1{{$key}}">
                                    @foreach($submenus as $key => $submenu)
                                      <li><a class="dropdown-item" href="{{$submenu->slug}}">{{$submenu->title}}</a></li>
                                     @endforeach
                                    </ul>
                                   
                                    @endif
                                </li>
                                
                                
                                @endforeach
                                <!-- <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink1" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Procurement
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDarkDropdownMenuLink1">
                                      <li><a class="dropdown-item" href="#">Goods</a></li>
                                      <li><a class="dropdown-item" href="#">Works</a></li>
                                      <li><a class="dropdown-item" href="#">Services</a></li>
                                    </ul>
                                </li> -->
<!-- 
                                <li class="nav-item">
                                    <a href="#" class="nav-link ">
                                        Careers
                                    </a>
                                </li>
                                -->

                            </ul>


                        </div>
                    </div>