<?php

class ChuvaModel
{
    private $mysqli;

    public function __construct($conexao)
    {
        $this->mysqli = $conexao;
    }

    public function getUltimaLeitura()
    {
        $sql = "SELECT * FROM sensor_readings ORDER BY id DESC LIMIT 1";
        $res = $this->mysqli->query($sql);
        return ($res && $res->num_rows > 0) ? $res->fetch_assoc() : null;
    }

    public function getLeitura3HorasAtras()
    {
        $sql = "
            SELECT * 
            FROM sensor_readings
            WHERE created_at <= DATE_SUB(NOW(), INTERVAL 3 HOUR)
            ORDER BY created_at DESC
            LIMIT 1
        ";
        $res = $this->mysqli->query($sql);

        if ($res && $res->num_rows > 0) {
            return $res->fetch_assoc();
        }

        // fallback → leitura anterior
        $sql2 = "SELECT * FROM sensor_readings ORDER BY id DESC LIMIT 1 OFFSET 1";
        $res2 = $this->mysqli->query($sql2);

        return ($res2 && $res2->num_rows > 0) ? $res2->fetch_assoc() : null;
    }

    public function calcularProbabilidadeChuva()
    {
        $atual = $this->getUltimaLeitura();
        $antiga = $this->getLeitura3HorasAtras();

        if (!$atual) {
            return ["status" => "erro", "msg" => "Nenhuma leitura disponível no banco"];
        }

        if (!$antiga) {
            $antiga = $atual;
        }

        // Dados
        $H = floatval($atual["umid"]) / 100.0;
        $T = floatval($atual["temp_c"]);
        $press_atual = floatval($atual["press"]);
        $press_antiga = floatval($antiga["press"]);
        $dP = $press_atual - $press_antiga;

        // Modelo SEM PoP
        $logit =
            -3.5 +         // base
            (2.5 * $H) +    // umidade aumenta chance
            (-0.9 * $dP) +  // queda de pressão indica chuva
            (0.015 * $T);   // temperatura influencia pouco

        $P = 1 / (1 + exp(-$logit));

        return [
            "status" => "ok",
            "prob_chuva" => round($P * 100, 2),
            "dados" => [
                "umidade" => $H,
                "temperatura" => $T,
                "pressao_atual" => $press_atual,
                "pressao_antiga" => $press_antiga,
                "delta_pressao" => $dP,
                "created_at_atual" => $atual["created_at"],
                "created_at_antiga" => $antiga["created_at"]
            ]
        ];
    }
}
