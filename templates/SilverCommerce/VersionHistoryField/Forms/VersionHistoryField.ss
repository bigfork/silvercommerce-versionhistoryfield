<% loop $Versions %>
    <div class="version-{$Version.Version}">
        <h4 class="version-author">
            <% if $Version.Author %>
                {$Version.Author.Name}
            <% else %>
                <%t SilverCommerce\VersionHistoryField.Unknown "Unknown" %>
            <% end_if %>
            ({$Version.LastEdited})
        </h4>

        <ul class="version-changes">
            <% loop $Diff.ChangedFields %>
                <li>
                    <strong>{$Title}:</strong>
                    <del>{$From}</del>
                    <ins>{$To}</ins>
                </li>
            <% end_loop %>
        </ul>
    </div>

    <% if not $Last %><hr><% end_if %>
<% end_loop %>