<style "text/css">
.visible { display: table-row; }
.hidden { display: none; }
</style>
<script language="JavaScript">
function showTR(n){ // n:行番号
　if(i <= n) {
　　document.getElementById('row_num_'+i+'_index').className = 'visible';
　　document.getElementById('row_num_'+i+'_content').className = 'visible';
  } else {
　　document.getElementById('row_num_'+i+'_index').className = 'hidden';
　　document.getElementById('row_num_'+i+'_content').className = 'hidden';
　}
}
</script>

<!-- <select onchange="showTR(this.selectedIndex + 1)">
 <?php
$MAX_NUMBER=10;
for ($i = 1; $i <= $MAX_NUMBER; $i++) {
echo '＜option value=\''.$i.'\'＞'.$i.'＜/option＞';
echo $i;
}
echo $i;
// echo '	<select onchange="showTR(this.selectedIndex + 1)">';
// echo '		<option value="1">1</option>';
// echo '		<option value="2">2</option>';
// echo '		<option value="3">3</option>';
// echo '	</select>';
?>
</select> -->

<select onchange="showTR(this.selectedIndex + 1)">
	<option value="1">1</option>
		<option value="2">2</option>
		<option value="3">3</option>
	</select>
<table>
<tr id="row_num_1_index" class = "hidden"><td>タイトル</td><td>タイトル</td></tr>
<tr id="row_num_1_content" class = "hidden"><td>内容</td><td>内容</td></tr>
<tr id="row_num_2_index"><td>タイトル</td><td>タイトル</td></tr>
<tr id="row_num_2_content"><td>内容</td><td>内容</td></tr>
<tr id="row_num_3_index"><td>タイトル</td><td>タイトル</td></tr>
<tr id="row_num_3_content"><td>内容</td><td>内容</td></tr>
</table>
