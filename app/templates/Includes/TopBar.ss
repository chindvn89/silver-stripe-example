<div id="top-bar">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">							
                <ul id="top-buttons">
                    <% loop $Menu(1) %>
                        <li><a class="$LinkingMode" href="$Link" title="Go to the $Title page">$MenuTitle</a></li>
                    <% end_loop %>
                </ul>
            </div>
        </div>
    </div>
</div>