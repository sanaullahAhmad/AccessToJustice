<style type="text/css">
    .dropdown-submenu {
        position: relative;
    }

    .dropdown-submenu>.dropdown-menu {
        top: 0;
        left: 100%;
        margin-top: -6px;
        margin-left: 0px;
        -webkit-border-radius: 0 6px 6px 6px;
        -moz-border-radius: 0 6px 6px;
        border-radius: 0 6px 6px 6px;
    }

    .dropdown-submenu:hover>.dropdown-menu {
        display: block;
    }

    .dropdown-submenu>a:after {
        display: block;
        content: " ";
        float: right;
        width: 0;
        height: 0;
        border-color: transparent;
        border-style: solid;
        border-width: 5px 0 5px 5px;
        border-left-color: #ccc;
        margin-top: 5px;
        margin-right: -10px;
    }

    .dropdown-submenu:hover>a:after {
        border-left-color: #fff;
    }

    .dropdown-submenu.pull-left {
        float: none;
    }

    .dropdown-submenu.pull-left>.dropdown-menu {
        left: -100%;
        margin-left: 13px;
        -webkit-border-radius: 6px 0 6px 6px;
        -moz-border-radius: 6px 0 6px 6px;
        border-radius: 6px 0 6px 6px;
    }



</style>
<div class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container" style="margin-left:-10px;width:100%;">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" style="margin-right:25px;" href="#" ><img  style="margin-left:10px;"src="{{asset('assets/images/White.png')}}" alt="ATJ" height="45px" /></a>
        </div>
        <div class="navbar-collapse collapse" >
            <ul class="nav navbar-nav">
                <li><a href="{{URL::to('dashboard')}}">Home</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Database Reports<b class="caret"></b></a>
                    <ul class="dropdown-menu">

                        <li><a href="{{ URL::route('walkin.index')}}/pre_index">WalkIn Visitors</a></li>
                        <li><a href="{{ URL::route('incoming.index')}}/pre_index">Incoming Call Log</a></li>
                        <li><a href="{{ URL::route('legalaid.index')}}/pre_index">Counselling & Legal Advice</a></li>
                        <li><a href="{{ URL::route('legalassistance.index')}}/pre_index">Legal Assistance</a></li>
                        <li><a href="{{ URL::route('cases.index')}}/pre_index">Court Cases</a></li>
                        <li><a href="{{ URL::route('clinic.index')}}/pre_index">Legal Aid Clinics</a></li>
                        <li><a href="{{ URL::route('paralegal.index')}}/pre_index">Community Paralegals</a></li>

                    </ul>
                </li>

                <li class="dropdown">
                    <a href="{{ URL::to('reports/')}}" class="dropdown-toggle"  >Analytical Reports</a>

                </li>

                <li class="dropdown">
                    <a href="{{URL::to('centeriec')}}" >IEC Material</a>
                </li>
                @if(Entrust::hasRole('Partner_User'))

                    <li class="dropdown">
                        <a href="{{ URL::route('meeting.index')}}">Joint Networking Meetings</a>
                    </li>

                @endif
                @if(Auth::check() && Entrust::hasRole('Admin'))
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Database Management <b class="caret"></b></a>
                        <ul class="dropdown-menu multi-level">
                            <li class="dropdown-submenu"><a href="" tabindex="-1">Users Management </a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{URL::route('adminusers.index')}}">Admins</a></li>
                                    <li><a href="{{URL::route('centerusers.index')}}">Centers</a></li>
                                    <li><a href="{{URL::route('normalusers.index')}}">Users</a></li>
                                </ul>
                            </li>

                            <li class="dropdown-submenu">
                                <a href="" tabindex="-1">Supporting Forms</a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{ URL::route('priority.index')}}">Priority Groups</a></li>
                                    <li><a href="{{ URL::route('minority.index')}}">Minority Groups</a></li>
                                    <li><a href="{{ URL::route('callnature.index')}}">Call Nature</a></li>
                                    <li><a href="{{ URL::route('callpurpose.index')}}">Call Purpose</a></li>
                                    <li><a href="{{ URL::route('casenature.index')}}">Case Nature</a></li>
                                    <li><a href="{{ URL::route('problem.index')}}">Problem Nature</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                @endif

                @if(Auth::check() && !Entrust::hasRole('Partner_User'))
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Project Profile<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ URL::route('netpartner.index')}}">Network Secretariat</a></li>
                            <li><a href="{{ URL::route('district.index')}}">District Profiles</a></li>
                            <li><a href="{{ URL::route('center.index')}}">Project Districts</a></li>
                            <li><a href="{{ URL::route('staff.index')}}">Project Staff</a></li>
                            <li><a href="{{ URL::route('lawyer.index')}}">Legal Aid Lawyers</a></li>
                            <li><a href="{{ URL::route('desk.index')}}">Legal Aid Desks</a></li>
                            <li><a href="{{ URL::route('trainer.index')}}">CP Master Trainers</a></li>
                            <li><a href="{{ URL::route('cptrainer.index')}}">CP Lead Trainers</a></li>
                            <li><a href="{{ URL::route('apprt.index')}}">Apprentiship Program</a></li>
                            <li><a href="{{ URL::route('paradb.index')}}">Community Paralegals</a></li>
                            <li><a href="{{ URL::route('partner.index')}}">Implementing Partners</a></li>
                            <li><a href="{{ URL::route('supportorg.index')}}">ROL Member Organizations</a></li>
                            <li><a href="{{ URL::route('meeting.index')}}">Coordination Meetings</a></li>
                        </ul>
                    </li>
                @endif

            </ul>
            <ul class="nav navbar-nav navbar-right" >


                @if(Auth::check())
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle" style="font-size:14px;" href="">Hi,{{Confide::user()->username}} <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a style="font-size:14px;" href="{{URL::to('users/settings')}}">Change Password</a></li>
                            <li><a style="font-size:14px;" href="{{URL::to('users/logout')}}">Log Out</a></li>
                        </ul>
                    </li>

                @else
                    <li><a style="font-size:14px;" href="#">Hi, Guest</a></li>
                    <li><a style="font-size:14px;" href="{{URL::to('users/login')}}">Login</a></li>
                @endif
            </ul>
        </div>
    </div>
</div>