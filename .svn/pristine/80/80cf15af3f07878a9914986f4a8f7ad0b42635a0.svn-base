<!DOCTYPE html>
<html lang="en">
<head>
<title>Simple Table</title>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
<script type="text/javascript">
 $(function() {
		/* For zebra striping */
        // $("table tr:nth-child(odd)").addClass("odd-row");
		/* For cell text alignment */
		$("table td:first-child, table th:first-child").addClass("first");
		/* For removing the last border */
		$("table td:last-child, table th:last-child").addClass("last");
});
</script>

<style type="text/css">

	html, body, div, span, object, iframe,
	h1, h2, h3, h4, h5, h6, p, blockquote, pre,
	abbr, address, cite, code,
	del, dfn, em, img, ins, kbd, q, samp,
	small, strong, sub, sup, var,
	b, i,
	dl, dt, dd, ol, ul, li,
	fieldset, form, label, legend,
	table, caption, tbody, tfoot, thead, tr, th, td {
		margin:0;
		padding:0;
		border:0;
		outline:0;
		font-size:100%;
		vertical-align:baseline;
		background:transparent;
	}
	
	body {
		margin:0;
		padding:0;
		font:12px/15px "Helvetica Neue",Arial, Helvetica, sans-serif;
		color: #555;
		background:#f5f5f5 url(bg.jpg);
	}
	
	a {color:#666;}
	
	#content {width:65%; max-width:690px; margin:6% auto 0;}
	
	/*
	Pretty Table Styling
	CSS Tricks also has a nice writeup: http://css-tricks.com/feature-table-design/
	*/
	
	table {
		overflow:hidden;
		border:1px solid #d3d3d3;
		background:#fefefe;
		width:70%;
		margin:5% auto 0;
		-moz-border-radius:5px; /* FF1+ */
		-webkit-border-radius:5px; /* Saf3-4 */
		border-radius:5px;
		-moz-box-shadow: 0 0 4px rgba(0, 0, 0, 0.2);
		-webkit-box-shadow: 0 0 4px rgba(0, 0, 0, 0.2);
	}
	
	th, td {padding:18px 28px 18px; text-align:center; }
	
	th {padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;}
	
	td {border-top:1px solid #e0e0e0; border-right:1px solid #e0e0e0;}
	
	tr.odd-row td {background:#f6f6f6;}
	
	td.first, th.first {text-align:left}
	
	td.last {border-right:none;}
	
	/*
	Background gradients are completely unnecessary but a neat effect.
	*/
	
	td {
		background: -moz-linear-gradient(100% 25% 90deg, #fefefe, #f9f9f9);
		background: -webkit-gradient(linear, 0% 0%, 0% 25%, from(#f9f9f9), to(#fefefe));
	}
	
	tr.odd-row td {
		background: -moz-linear-gradient(100% 25% 90deg, #f6f6f6, #f1f1f1);
		background: -webkit-gradient(linear, 0% 0%, 0% 25%, from(#f1f1f1), to(#f6f6f6));
	}
	
	th {
		background: -moz-linear-gradient(100% 20% 90deg, #e8eaeb, #ededed);
		background: -webkit-gradient(linear, 0% 0%, 0% 20%, from(#ededed), to(#e8eaeb));
	}
	
	/*
	I know this is annoying, but we need additional styling so webkit will recognize rounded corners on background elements.
	Nice write up of this issue: http://www.onenaught.com/posts/266/css-inner-elements-breaking-border-radius
	
	And, since we've applied the background colors to td/th element because of IE, Gecko browsers also need it.
	*/
	
	tr:first-child th.first {
		-moz-border-radius-topleft:5px;
		-webkit-border-top-left-radius:5px; /* Saf3-4 */
	}
	
	tr:first-child th.last {
		-moz-border-radius-topright:5px;
		-webkit-border-top-right-radius:5px; /* Saf3-4 */
	}
	
	tr:last-child td.first {
		-moz-border-radius-bottomleft:5px;
		-webkit-border-bottom-left-radius:5px; /* Saf3-4 */
	}
	
	tr:last-child td.last {
		-moz-border-radius-bottomright:5px;
		-webkit-border-bottom-right-radius:5px; /* Saf3-4 */
	}

</style>

</head>
<body>

<div id="content">

    <table cellspacing="0">  
	    <?php
				$dbhost = 'localhost';  // mysql服务器主机地址
				$dbuser = 'root';            // mysql用户名
				$dbpass = 'root';          // mysql用户名密码
				//数据库名字，更改自己的数据库
				$table = 'nic_new_admin';
				
				$conn = mysqli_connect($dbhost, $dbuser, $dbpass);
				if(! $conn )
				{
				    die('Could not connect: ' . mysqli_error());
				}
				$conn->query("set names utf8");



				// echo '数据库连接成功！';

				//查询出表名的备注和注释
				$sql2 = "SELECT TABLE_NAME 表名,  TABLE_COMMENT 表注释 FROM information_schema.TABLES WHERE table_schema='{$table}';";
				$result2 = $conn->query($sql2);

				$data = [];

				while($row2 = $result2->fetch_assoc()){
					$data[$row2['表名']] = $row2['表注释'];  
				}

				



				$sql = "SELECT
					TABLE_NAME 表名,
				   	COLUMN_NAME 列名,
				    COLUMN_TYPE 数据类型,  
				  	IS_NULLABLE 是否为空, 
				  	COLUMN_COMMENT 备注
				FROM
				 	INFORMATION_SCHEMA.COLUMNS
				where 
					table_schema ='{$table}'";
				
				$temp = '';
				$result = $conn->query($sql); 
				 while($row = $result->fetch_assoc()) {

				 		

				 		if($row['表名'] != $temp){ 
				 			
				 			$temp = $row['表名'];
				 			echo "<tr><td colspan='5'></td></tr>";
				 			echo "<tr><td colspan='5'></td></tr>";
				 			echo "<tr class='odd-row' ><td colspan='5' class='first last' >{$row['表名']}--{$data[$row['表名']]}</td></tr>";

				 			// echo "<tr><td>表名</td><td>字段</td><td>数据类型</td> <td>默认值</td><td>备注</td></tr>";
				 			echo "<tr>  <th>字段</th> <th>数据类型</th>   <th>默认值</th>  <th>备注</th> </tr>";
				 			
				 		}

				 		echo  "<tr>"; 
				 		echo "<td>{$row['列名']}</td>";
				 		echo "<td>{$row['数据类型']}</td>";
				 		echo "<td>{$row['是否为空']}</td>"; 
				 		echo "<td>{$row['备注']}</td>"; 
				 		echo "</tr>";
				        


				    }



?> 
    </table>

</div>

</body>
</html>




