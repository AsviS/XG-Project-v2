<script>document.body.style.overflow = "auto";</script>
<body>
<table width="70%">
	<tr>
		<td class="c" colspan="8">{er_php_error_list} [<a href="?errors=php&amp;deleteall=yes">{er_dlte_all}</a>]</td>
	</tr>
	<tr>
		<td class="b" colspan="8">
			<form action="?errors=php" method="post" accept-charset="UTF-8">{er_php_show}:
				<input type="checkbox" name="show_2"{checked_2}> E_WARNING
				<input type="checkbox" name="show_8"{checked_8} > E_NOTICE
				<input type="checkbox" name="show_2048"{checked_2048}> E_STRICT
				<input type="checkbox" name="show_4096"{checked_4096}> E_RECOVERABLE_ERROR
				<input type="checkbox" name="show_8192"{checked_8192}> E_DEPRECATED
				<input type="checkbox" name="show_32767"{checked_32767}> E_ALL
				<input type="submit" name="submit" value="{er_filter}">
			</form>
		</td>
	</tr>
	<tr>
		<th class="b" colspan="8">{total_errors} {er_errors}</td>
	</tr>
	<tr>
		<td class="c" width="25">{input_id}</td>
		<td class="c" width="170">{er_date}</td>
		<td class="c" width="230">{er_user}</td>
		<td class="c" width="230">{er_level}</td>
		<td class="c" width="230">{er_file}</td>
		<td class="c" width="230">{er_line}</td>
		<td class="c" width="230">{er_data}</td>
		<td class="c" width="95">{button_delete}</td>
	</tr>
	{errors_list}
</table>
</body>