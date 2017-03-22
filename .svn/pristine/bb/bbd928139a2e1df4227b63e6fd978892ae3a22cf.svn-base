<?php

class navigation{
	public static function getNavigation($idNav, $idParentNode, $recursive, $loc) {
		$pdo = database::connect();
		
		$params = array(':idNav' => $idNav);
		
		$query = '
			SELECT
					htmlId
				FROM
					t_cms_navigation
				WHERE
					idNavigation = :idNav
				LIMIT
					1
		';
		
	    $stmt = $pdo->prepare($query);
	    
	    if($stmt->execute($params)){
	    	$row = $stmt->fetch(PDO::FETCH_NUM);
	    	
	    	$htmlId = $row[0];
		
			$html = "<div id='" . $htmlId . "' class='nav'>";
			$html .= self::getNavNodes($idNav, $idParentNode, $recursive, 1, $loc);
			$html .= "</div>";

			return $html;
	    }
	    else{
	    	return 'The Menu could not be read: DB ERROR!';
	    }
	}
    
    private static function getNavNodes($idNav, $idParentNode, $recursive, $level, $loc) {
		$pdo = database::connect();
		
		$params = array(':lng' => $loc, ':idParentNode' => $idParentNode, ':idNav' => $idNav);
		$query = '
			SELECT
					n.idNode
				,	COALESCE(t.label, n.label) AS label
				,	n.url
				,	n.icon
				,	COALESCE(n2.count, 0) AS count
				FROM
					t_cms_node AS n
				LEFT JOIN
					(SELECT
							idParentNode
						,	COUNT(*) AS count
						FROM
							t_cms_node
						GROUP BY
							idParentNode) AS n2
					ON n.idNode = n2.idParentNode
				LEFT JOIN
					t_cms_cms AS t
					ON	n.idCms = t.idCms
					AND	t.idLanguage = :lng
				WHERE
					n.idParentNode = :idParentNode
				AND	idNavigation = :idNav
				AND active = 1
				ORDER BY
					sort ASC
		';
		
		$stmt = $pdo->prepare($query);
		
		if($stmt->execute($params)){
			$result = $stmt->fetchAll(PDO::FETCH_OBJ);
			
			$menuClass = 'sf-menu';
			$lastClass = 'lasdt3';
			
			$html = ($level == 1 ? "<ul class='" . $menuClass . "'>" : "<ul>");
			
			foreach($result as $index => $row){
				$hasChildren = $row->count > 0;
				$subNav = ($hasChildren && $recursive == true ? $subMenu = self::getNavNodes($idNav, $row->idNode, $recursive, $level + 1, $loc) : "");
				
				$lastClass = (($index == (count($result)-1) && $level == 1 && strlen($lastClass) > 0) ? ' class="' . $lastClass . '"' : '');

				$arrow = ($hasChildren ? '<i class="fa fa-caret-right arrow"></i>' : '');
				
				$li = '
					<li' . $lastClass . '>
						<a href="/' . $loc . $row->url . '">
							<span>
								<i class="fa fa-' . $row->icon . '"></i>' . utf8_encode($row->label) . $arrow . '
							</span>
						</a>
						' . $subNav . '
					</li>
				';
		    	
				$html .= $li;
		       
		    }
		    $html .= "</ul>";
			
		    return $html;
		}
	}
}

?>