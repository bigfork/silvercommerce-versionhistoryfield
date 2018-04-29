<% if not $Versions.exists %>
    <p><%t SilverCommerce\VersionHistoryField.NoHistory "This object has no history" %></p>
<% end_if %>

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

        <% if $Version.Version == 1 %>
            <p><%t SilverCommerce\VersionHistoryField.FirstVersion "First Version" %></p>
        <% else %>
            <ul class="version-changes">
                <% if not $Diff.ChangedFields.exists %>
                    <li><%t SilverCommerce\VersionHistoryField.NoChanges "No Changes" %></li>
                <% end_if %>

                <% loop $Diff.ChangedFields %>
                    <li>
                        <strong>{$Title}:</strong>
                        <del>{$From}</del>
                        <ins>{$To}</ins>
                    </li>
                <% end_loop %>
            </ul>
        <% end_if %>
    </div>

    <% if not $Last %><hr><% end_if %>
<% end_loop %>