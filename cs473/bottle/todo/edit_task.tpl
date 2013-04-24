%#template for editing a task
%#the template expects to receive a value for "no" as well as "old", text of selected ToDo item
<p>Edit the task with ID = {{no}}</p>
<form action="/edit/{{no}}" method="POST">
	<input type="text" name="task" value="{{old}}" size="100" maxlength="100">
	<select name="status">
		%if open == 1:
			<option selected="selected">open</option>
			<option>closed</option>
		%else:
			<option>open</option>
			<option selected="selected">closed</option>
		%end
		
	</select>
	<br/>
	<input type="submit" name="save" value="save">
</form>
<br>
<a href="/">Task List</a>