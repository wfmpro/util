<?php
//Idea is to make a library that can draw charts in many ways. Start basic, generalize later.
//This is the Chart class
class Chart
{
	//Bar chart
	public function Bar(...$data){
		$mi = imagecreatetruecolor(210,210);
		$colorbar = imagecolorallocate($mi,255,0,0);
		$colorspc = imagecolorallocate($mi,0,0,0);		
		$index = 3; //increasing or decresing this will move the chart horizontally
		
		foreach($data as $n){
			imagefilledrectangle($mi, ($index*10)-9, 200,($index*10)-1,200-$n,$colorbar);
			imagefilledrectangle($mi, ($index*10)-1, 200,($index*10)-1,200-$n,$colorspc);
			$index = $index+1;
		}		
		
		header('Content-type: image/png');
		imagepng($mi);
		imagedestroy($mi);
	}
	
	//$data = angles in degrees
	public function Pie(...$data){
		$mi = imagecreatetruecolor(200,200);
		$transparent = imagecolorallocatealpha($mi,255,255,255,0);
		imagefill($mi, 0,0, $transparent);
		imagesavealpha($mi,TRUE);		
		$sorted = array();
		
		foreach($data as $n){
			if($n>360){
				$sorted[360] = 360;
				$sorted[$n] = $n/($n%360);
			} else {
				$sorted[$n] = $n;
			}
		}		
		
		rsort($sorted);
		
		foreach($sorted as $m){			
			if($m > 180)	{
				if($m > 255){					
					if($m >= 360){
						$col = imagecolorallocate($mi,250,0,100);
					} else {
						$col = imagecolorallocate($mi,0,$m,0);
					}
				} else {
					$col = imagecolorallocate($mi,$m,0,0);
				}
			} else {
				$col = imagecolorallocate($mi,$m,$m,$m);
			}
			//this is so we can work with positive anti-clockwise angle notation.
			$angle = 360-$m;
			imagefilledarc($mi,100,100,100,100,$angle,0,$col, IMG_ARC_PIE);
		}

		header('Content-type: image/png');
		imagepng($mi);
		imagedestroy($mi);
	}
}
?>
