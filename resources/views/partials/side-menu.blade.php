<li {{ Request::is('states') ? 'class=active' : '' }}>
    <a href="{{ route('states.index') }}">
        <i class="fa fa-dropbox"></i>
        <span>States</span>
    </a>
</li>

<li {{ Request::is('counties') ? 'class=active' : '' }}>
    <a href="{{ route('counties.index') }}">
        <i class="fa fa-dropbox"></i>
        <span>Counties</span>
    </a>
</li>
