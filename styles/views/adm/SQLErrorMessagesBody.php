<script>document.body.style.overflow = "auto";</script>
<body>
<table width="70%">
	<tr>
		<td class="c" colspan="5">{er_error_list} [<a href="?errors=sql&amp;deleteall=yes">{er_dlte_all}</a>]</td>
	</tr>
	<tr>
		<td class="b" colspan="5">{total_errors} {er_errors}</td>
	</tr>
	<tr>
		<td class="c" width="25">{input_id}</td>
		<td class="c" width="170">{er_type}</td>
		<td class="c" width="230">{er_data}</td>
		<td class="c" width="95">{button_delete}</td>
	</tr>
	{errors_list}
</table>
</body>