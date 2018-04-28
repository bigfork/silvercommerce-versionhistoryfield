<div id="$HolderID" class="field<% if $extraClass %> $extraClass<% end_if %>">
	<% if $Title %><h2 class="left" for="$ID">$Title</h2><% end_if %>
	<% if $RightTitle %><span class="right" for="$ID">$RightTitle</span><% end_if %>
	<% if $Message %><span class="message $MessageType">$Message</span><% end_if %>
	<% if $Description %><span class="description">$Description</span><% end_if %>
	
	$Field
</div>
