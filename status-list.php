<?php require 'header.php'; ?>

<!-- Main -->
	<div id="main">
		<div class="inner">

				<!-- Header -->
				<?php require 'header-sub.php'; ?>

				<!-- statusListMain -->
				<section id="statusListMain">

					<div class="table-wrapper">
						<table class="alt">
							<thead>
								<tr>
									<th>更新</th>
									<th>お問合せ番号</th>
									<th>事象・内容</th>
									<th>SBS回答</th>
								</tr>
							</thead>
							<tbody>

							<?php
								//ログイン者と同じ病院コードの問合せを検索（継続中のみ）
								$sql=$pdo->prepare('select * from inquiry where facility_code=?');
								$sql->execute([$_SESSION['userinfo']['facility_code']]);
								foreach ($sql as $row) {

									echo '<tr>';
									echo '	<td>　</td>';
									echo '	<td>', $row['inquiry_no'], '</td>';
									echo '	<td>', $row['contents'], '</td>';
									echo '	<td>', $row['sbs_comment'], '</td>';
									echo '</tr>';

								}
							?>

							</tbody>
							<tfoot>
								<tr>
									<td colspan="2"></td>
									<td>100.00</td>
								</tr>
							</tfoot>
						</table>
					</div>
				</section>

			</div>
		</div>

<?php require 'menu.php'; ?>
<?php require 'footer.php'; ?>
