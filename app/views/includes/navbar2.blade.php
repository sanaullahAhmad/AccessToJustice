<!-- <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: auto;"><div class="sidebar-scroll" style="overflow: hidden; width: auto; height: auto;"> -->
<div class="sidebar-scroll">
    <div class="sidebar-content">
        <a class="sidebar-brand" href="{{URL::to('dashboard')}}">
            <strong>Access to Justice</strong> <small></small>
        </a>
        <div class="sidebar-section sidebar-user clearfix">
            <div class="sidebar-user-avatar" style="background: #000;">
                <a href="{{URL::to('dashboard')}}">
                    <img alt="avatar" src="{{asset('assets/images/White.png')}}">
                </a>
            </div>
            <div class="sidebar-user-name">{{Confide::user()->username}}</div>
            <div class="sidebar-user-links">
                <!-- <a title="" data-placement="bottom" data-toggle="tooltip" href="./page_ready_user_profile.php.html" data-original-title="Profile"><i class="gi gi-user"></i></a>
                <a title="" data-placement="bottom" data-toggle="tooltip" href="./page_ready_inbox.php.html" data-original-title="Messages"><i class="gi gi-envelope"></i></a> -->
                <a title="" data-placement="bottom" class="enable-tooltip" href="{{URL::to('users/settings')}}"><i class="gi gi-cogwheel"></i></a>
                <a title="" data-placement="bottom" data-toggle="tooltip" href="{{URL::to('users/logout')}}" data-original-title="Logout"><i class="gi gi-exit"></i></a>
            </div>
        </div>


        <ul class="sidebar-nav">
            <li>
                <a class=" active" href="{{URL::to('dashboard')}}"><i class="gi gi-stopwatch sidebar-nav-icon"></i>Dashboard</a>
            </li>
            <li class="sidebar-header">
                <span class="sidebar-header-options clearfix"><a title="" data-toggle="tooltip" href="javascript:void(0)" data-original-title="Quick Settings"><i class="gi gi-settings"></i></a></span>
                <span class="sidebar-header-title">Reports</span>
            </li>
            <li>
                <a class="sidebar-nav-menu" href="#"><i class="fa fa-angle-left sidebar-nav-indicator"></i><i class="fa fa-database sidebar-nav-icon"></i>Database Reports</a>
                <ul>
                    <li><a href="{{ URL::route('walkin.index')}}/pre_index">WalkIn Visitors</a></li>
                    <li><a href="{{ URL::route('incoming.index')}}/pre_index">Incoming Call Log</a></li>
                    <li><a href="{{ URL::route('outgoing.index')}}/pre_index">Outgoing Call Log</a></li>
                    <li><a href="{{ URL::route('legalaid.index')}}/pre_index">Counselling & Legal Advice</a></li>
                    <li><a href="{{ URL::route('legalassistance.index')}}/pre_index">Legal Assistance</a></li>
                    <li><a href="{{ URL::route('cases.index')}}/pre_index">Court Cases</a></li>
                    <li><a href="{{ URL::route('sycop.index')}}/pre_index">Sycop Calls</a></li>
                    {{--<li><a href="{{ URL::route('clinic.index')}}/pre_index">Legal Aid Clinics</a></li>
                    <li><a href="{{ URL::route('paralegal.index')}}/pre_index">Community Paralegals</a></li>--}}
                </ul>
            </li>

            <li>
                <a href="{{ URL::to('reports/')}}"><i class="gi gi-charts sidebar-nav-icon"></i>Analytical Reports</a>
            </li>

            <li>
                <a href="{{URL::to('centeriec')}}" ><i class="gi gi-file sidebar-nav-icon"></i> IEC Material</a>
            </li>
            <li>
                <a href="{{URL::route('event.index')}}" ><i class="gi gi-table sidebar-nav-icon"></i>Events</a>
            </li>
            <li>
                <a href="{{ URL::to('calendar')}}"><i class="gi gi-charts sidebar-nav-icon"></i>Calendar</a>
            </li>
         {{--   @if(Entrust::hasRole('Partner_User'))

                <li>
                    <a href="{{ URL::route('meeting.index')}}">Joint Networking Meetings</a>
                </li>

            @endif--}}
            @if(Auth::check() && Entrust::hasRole('Admin'))



                <li class="sidebar-header">
                    <span class="sidebar-header-options clearfix"><a title="" data-toggle="tooltip" href="javascript:void(0)" data-original-title="Quick Settings"><i class="gi gi-settings"></i></a></span>
                    <span class="sidebar-header-title">Database Management</span>
                </li>

                <li>
                    <a class="sidebar-nav-menu" href="#"><i class="fa fa-angle-left sidebar-nav-indicator"></i><i class="fa fa-cogs sidebar-nav-icon"></i>Users Management</a>
                    <ul>
                        <li><a href="{{URL::route('adminusers.index')}}">Admins</a></li>
                        <li><a href="{{URL::route('centerusers.index')}}">Centers</a></li>
                       {{-- <li><a href="{{URL::route('Center_User.index')}}">Partners</a></li>--}}
                        <li><a href="{{URL::route('normalusers.index')}}">Users</a></li>
                    </ul>
                </li>
                <li>
                    <a class="sidebar-nav-menu" href="#"><i class="fa fa-angle-left sidebar-nav-indicator"></i><i class="gi gi-table sidebar-nav-icon"></i>Supporting Forms</a>
                    <ul>
                        <li><a href="{{ URL::route('priority.index')}}">Priority Groups</a></li>
                        <li><a href="{{ URL::route('minority.index')}}">Minority Groups</a></li>
                        <li><a href="{{ URL::route('callnature.index')}}">Call Nature</a></li>
                        <li><a href="{{ URL::route('callpurpose.index')}}">Call Purpose</a></li>
                        <li><a href="{{ URL::route('casenature.index')}}">Case Nature</a></li>
                        <li><a href="{{ URL::route('problem.index')}}">Problem Nature</a></li>
                        <li><a href="{{ URL::route('daterange.edit')}}">Date Range</a></li>
                        <li><a href="{{ URL::route('heardabout.index')}}">Heard About</a></li>
                        <li><a href="{{ URL::route('eventscategories.index')}}">Events Categories</a></li>
                        <li><a href="{{ URL::route('defaultemail.index')}}">Default Emails</a></li>
                        <li><a href="{{ URL::route('defaultnumber.index')}}">Default Numbers</a></li>
                        {{--<li><a href="{{ URL::route('callender')}}">Callender</a></li>--}}
                    </ul>
                </li>
            @endif

            @if(Auth::check() && !Entrust::hasRole('Center_User'))

                <li>
                    <a class="sidebar-nav-menu" href="#"><i class="fa fa-angle-left sidebar-nav-indicator"></i><i class="fa fa-clipboard sidebar-nav-icon"></i>Project Profile</a>
                    <ul>
                        {{--<li><a href="{{ URL::route('netpartner.index')}}">Network Secretariat</a></li>--}}
                        <li><a href="{{ URL::route('district.index')}}">District Profiles</a></li>
                        <li><a href="{{ URL::route('center.index')}}">Project Districts</a></li>
                        <li><a href="{{ URL::route('staff.index')}}">Project Staff</a></li>
                        <li><a href="{{ URL::route('lawyer.index')}}">Legal Aid Lawyers</a></li>
                        {{-- <li><a href="{{ URL::route('desk.index')}}">Legal Aid Desks</a></li>
                        <li><a href="{{ URL::route('partner.index')}}">Implementing Partners</a></li>--}}
                        <li><a href="{{ URL::route('supportorg.index')}}">ROL Member Organizations</a></li>
                        <li><a href="{{ URL::route('meeting.index')}}">Coordination Meetings</a></li>
                    </ul>
                </li>

                {{--<li>
                    <a class="sidebar-nav-menu" href="#"><i class="fa fa-angle-left sidebar-nav-indicator"></i><i class="fa fa-clipboard sidebar-nav-icon"></i>Community Paralegal</a>
                    <ul>
                        <li><a href="{{ URL::route('trainer.index')}}">CP Master Trainers</a></li>
                        <li><a href="{{ URL::route('cptrainer.index')}}">CP Lead Trainers</a></li>
                        <li><a href="{{ URL::route('paradb.index')}}">Community Paralegals</a></li>
                    </ul>
                </li>--}}

                {{-- <li>
                     <a class="sidebar-nav-menu" href="#"><i class="fa fa-angle-left sidebar-nav-indicator"></i><i class="fa fa-clipboard sidebar-nav-icon"></i>Apprenticeship</a>
                     <ul>
                         <li><a href="{{ URL::route('apprt.index')}}">Apprentiship Program</a></li>
                    </ul>
                </li>--}}
            @endif

            {{--<li>
                <a class="sidebar-nav-menu" href="#"><i class="fa fa-angle-left sidebar-nav-indicator"></i><i class="fa fa-clipboard sidebar-nav-icon"></i>EDACE Reporting</a>
                <ul>

                    <li><a href="{{ URL::route('form1.index')}}">Form01: ACR</a></li>
                    <li><a href="{{ URL::route('form2.index')}}">Form02: List of BENEF </a></li>
                    <li><a href="{{ URL::route('form3.index')}}">Form03: List of Groups</a></li>
                    <li><a href="{{ URL::route('form4.index')}}">Form04: List of Assistance</a></li>
                    <li><a href="{{ URL::route('form5.index')}}">Form05: List of Audio-Visual</a></li>
                    <li><a href="{{ URL::route('form6.index')}}">Form06: List of Products</a></li>

                </ul>
            </li>--}}



            <li><a href="{{URL::to('users/logout')}}"><i class="gi gi-exit sidebar-nav-icon"></i> Log Out</a></li>

    </div>
</div>
<!-- <div class="slimScrollBar" style="background: rgb(255, 255, 255) none repeat scroll 0% 0%; width: 3px; position: absolute; border-radius: 7px; z-index: 99; right: 1px; top: 0px; height: 195.912px; display: none; opacity: 0.4;"></div><div class="slimScrollRail" style="width: 3px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51) none repeat scroll 0% 0%; opacity: 0.2; z-index: 90; right: 1px;"></div> -->
</div>