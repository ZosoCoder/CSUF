%#template to generate a HTML table from a list of tuples
<p>The {{status}} items are as follows:</p>
<table border="1">
	%for id,task in tasks.items():
		<tr>
			<td>{{ id }}</td>
			<td>{{ task[0] }}</td>
		</tr>
	%end
</table>