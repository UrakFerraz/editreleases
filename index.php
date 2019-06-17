<?php
?>

<!DOCTYPE html>

<script>
setTimeout(function () {location.href=location.href;} , 20000);
</script>

<body>
<?php

$flx=glob("./producao/*");
$fly=glob("*");
$flz=glob("./provas/*");
$flt=glob("./producao/icones/*");
$flz2=glob("./htmlfinalizados/*");

$fla=array_merge($flx, $fly);
$fl1=array_merge($fla, $flz);
$fl2=array_merge($fl1, $flt);
$fl=array_merge($fl1, $flz2);

usort($fl, create_function('$a,$b', 'return filemtime($b) - filemtime($a);'));

$lasthash=0;

foreach ($fl as $f)
	{
		$fl2=glob($f."/*");

		usort($fl2, create_function('$a,$b', 'return filemtime($b) - filemtime($a);'));

		foreach ($fl2 as $f2)
			{
				if (is_dir($f2)) continue;

				$xx=explode("/", $f2);

				$zc="";
				for ($z=0;$z<count($xx)-1;$z++)
					{
						$zc.=$xx[$z];
					}
				
				$hash=md5($zc);

				if ($hash!=$lasthash)
					{
						echo "<hr>";
					}
				$lasthash=$hash;

				$cdate=date("Ymd-His", filemtime($f2));
				$dfn="./.diff/".$f2."_".$cdate;

				if (!file_exists($dfn))
					{

						$fx=explode("/", $f2);

						$fxx="./.diff/";

						for ($o=0;$o<count($fx)-1;$o++)
							{
								$fxx.=$fx[$o]."/";

								//								echo "mkdir (".$fxx.")<br>";

								@mkdir($fxx);
							}

						//						echo "copy ".$f2."  ".$dfn."\n<br>";
						
						copy($f2, $dfn);


					}

						$fxxx="./.diff/".$f2."*";

						//						echo $fxxx."<br>";
						$fxg=glob($fxxx);
						$rt="";
						
						foreach ($fxg as $gg)
							{
								$gx=explode("_", $gg);

								if ($cdate!=$gx[1])
									{
										//									echo $rs."\n<br>";
										if (!isset($_GET['diff']))
											{
												$rs="";
											}
										else
											{
												$cmd="diff -wd ".$f2." ".$gg." | grep \"^[<>]\" ";
												$rs=htmlentities(shell_exec($cmd));
												$rs=str_replace("&lt;", "&lt;<br>", $rs);
											}
										$rt.="<a href=\"".$gg."\">(".$gx[1].")</a><span onclick=\"\"><span style=\"\">".$rs."</span>diff</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
										//										echo $gx[1]."\n<br>";
									}
							}
						//						print_r($fxg);
				
				
				echo "<a href=\"".$f2."\">".$f2." (".date("Ymd-His", filemtime($f2)).")</a> ".$rt." <br>";
			}
	}

?>
<hr>

</body>


</html>
