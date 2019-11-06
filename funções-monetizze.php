	public static function cleanMaskMoney($value)
	{
		$value = str_replace ( '.' , '' , $value );
		$value = str_replace ( ',' , '.', $value );
		$value = str_replace ( '/' , '' , $value );
		$value = str_replace ( '-' , '' , $value );

		return $value;
	}
	public static function perc($value1, $value2)
	{
		if($value1 == 0 || $value2 == 0)
			$var = '-';
		else
			$var = bcdiv(bcmul($value1, 100, 2), $value2, 2).'%';
			
		return $var;
	}

	public static function moeda($valor, $moeda, $showMoeda)
	{	
		$tipoMoeda = array(
			'R$'  => 'BRL',
			'US$' => 'USD'
		);

		if($moeda == 'BRL')
		{
			$fValor = @number_format(str_replace(',', '', $valor), 2, ',', '.');
		}
		else if($moeda == 'USD')
		{
			$fValor = @number_format(str_replace(',', '', $valor), 2, '.', ',');
		}

		if($showMoeda == true)
			$fValor = array_search($moeda, $tipoMoeda).' '.$fValor;

		return $fValor;              
	}
	public static function randomColor()
	{
		$rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
		$color = '#'.$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];
		return $color;
	}

	public static function mascararCartao($n_cartao)
	{
		if(strlen($n_cartao) > 15)
		{
			$parte1 = substr($n_cartao,0,6);
			$parte2 = substr($n_cartao,12);

			return $parte1.'******'.$parte2;
		}
		else
		{
			
			$parte1 = substr($n_cartao,0,6);
			$parte2 = substr($n_cartao,11);

			return $parte1.'*****'.$parte2;
		}
	}


	public static function getStatus($idStatus)
	{

		$model = new Model;
		$db = $model->getConnection();

		$traducao = (( isset($_SESSION['idioma']) && $_SESSION['idioma'] == '2') ? '_en' : '' );

		$sql = "SELECT id_status, status$traducao as status FROM status WHERE id_status = :id_status";

		try {
				
			$query = $db->prepare($sql);
			$query->bindParam(':id_status', $idStatus, PDO::PARAM_INT);
			$query->execute();

			$row = $query->fetch(PDO::FETCH_ASSOC);

			return ((isset($row['status'])) ? $row['status'] : null);

		} catch (PDOException $e) {
			return $e->getMessage();
		}
	}

	public static function datetime($datetime)
	{
		if(!empty($datetime)){
			$datetime = date('d/m/Y H:i:s﻿﻿', strtotime($datetime));
			return $datetime;
		}else{
			return '__/__/__ --:--';
		}
	}
	public function date($date)
	{

		if(!empty($date)){
			$date = date('d/m/Y', strtotime($date));
			return $date;
		}else{
			return '__/__/__';
		}
	}

	

	public static function data_correct($data_banco)
	{
		$data_atual = date('Y-m-d');
		$dt = explode('-', $data_banco);
		$ano_array = $dt[0];
		$mes_array = $dt[1];
		$dia_array = $dt[2];
		$numero_mes = date($mes_array)*1; //mes
		$numero_dia = date('w', strtotime($data_banco))*1; 

	    $dia = array('Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado');
	    $mes = array('', 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');

	    $datetime1 = date_create($data_banco);
	    $datetime2 = date_create($data_atual);
	    $interval = date_diff($datetime2, $datetime1);
	    $data = $interval->format('%R%a');

	    $data = $dia[$numero_dia] . ", " .$dia_array . " de " . $mes[$numero_mes] . " de " . $ano_array . "<br><label class='text-danger'>".$data.'</label> dias restante';

		    return $data;
	}
