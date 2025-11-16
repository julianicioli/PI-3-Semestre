// src/components/Clima.jsx
import React, { useEffect, useState } from "react";
import axios from "axios";
import {
  LineChart,
  Line,
  XAxis,
  YAxis,
  Tooltip,
  CartesianGrid,
  ResponsiveContainer,
} from "recharts";
import {
  Sun,
  Cloud,
  CloudRain,
  CloudLightning,
  CloudDrizzle,
  Snowflake,
  CloudFog,
} from "lucide-react";

export default function Clima() {
  const [forecast, setForecast] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState("");

  // Mapeia condição do tempo → ícone Lucide
  const getIcon = (main) => {
    const map = {
      Clear: <Sun size={26} color="#f39c12" />,
      Clouds: <Cloud size={26} color="#7f8c8d" />,
      Rain: <CloudRain size={26} color="#3498db" />,
      Thunderstorm: <CloudLightning size={26} color="#9b59b6" />,
      Drizzle: <CloudDrizzle size={26} color="#5dade2" />,
      Snow: <Snowflake size={26} color="#85c1e9" />,
      Mist: <CloudFog size={26} color="#95a5a6" />,
      Fog: <CloudFog size={26} color="#95a5a6" />,
      Haze: <CloudFog size={26} color="#95a5a6" />,
    };
    return map[main] || <Cloud size={26} />;
  };

  useEffect(() => {
    const fetchForecast = async () => {
      try {
        const API_KEY = "8eb51366b2d05b353c9550d8292b02c6";
        const city = "Itapira";

        const res = await axios.get(
          `https://api.openweathermap.org/data/2.5/forecast?q=${city}&units=metric&appid=${API_KEY}&lang=pt_br`
        );

        // Agrupar por dia
        const grouped = res.data.list.reduce((acc, f) => {
          const day = f.dt_txt.split(" ")[0];
          if (!acc[day]) acc[day] = { temps: [], hums: [], weathers: [], date: day };
          acc[day].temps.push(f.main.temp);
          acc[day].hums.push(f.main.humidity);
          acc[day].weathers.push(f.weather[0]);
          return acc;
        }, {});

        const dailyData = Object.values(grouped)
          .slice(0, 5)
          .map((d) => {
            const avgTemp = d.temps.reduce((a, b) => a + b, 0) / d.temps.length;
            const avgHum = d.hums.reduce((a, b) => a + b, 0) / d.hums.length;
            const mainWeather = d.weathers[0];

            return {
              date: new Date(d.date).toLocaleDateString("pt-BR", { weekday: "short" }),
              temp: avgTemp.toFixed(1),
              humidity: avgHum.toFixed(1),
              main: mainWeather.main,
              description: mainWeather.description,
            };
          });

        setForecast(dailyData);
        setLoading(false);
      } catch (err) {
        console.error("Erro ao buscar previsão:", err);
        setError("Não foi possível carregar os dados do clima.");
        setLoading(false);
      }
    };

    fetchForecast();
  }, []);

  return (

    <div className="p-4 bg-white rounded-3 shadow-sm">
      <h5 className="mb-3 fw-semibold">Previsão do Tempo — Itapira (5 dias)</h5>

      {loading ? (
        <p className="text-muted">Carregando dados do clima...</p>
      ) : error ? (
        <p className="text-danger">{error}</p>
      ) : (
        <>
          {/* Gráfico de temperatura e umidade */}
          <ResponsiveContainer width="100%" height={250}>
            <LineChart data={forecast}>
              <CartesianGrid strokeDasharray="3 3" />
              <XAxis dataKey="date" />
              <YAxis />
              <Tooltip />

              {/* Primeira linha: umidade */}
              <Line
                type="monotone"
                dataKey="humidity"
                stroke="#3498db"
                name="Umidade (%)"
              />

              {/* Segunda linha: temperatura */}
              <Line
                type="monotone"
                dataKey="temp"
                stroke="#f39c12"
                name="Temperatura (°C)"
              />
            </LineChart>
          </ResponsiveContainer>



          {/* Cartões de previsão */}
          <div className="d-flex justify-content-around mt-4 flex-wrap">
            {forecast.map((day) => (
              <div
                key={day.date}
                className="text-center m-2 p-2 rounded"
                style={{ width: "90px", backgroundColor: "#f8f9fa" }}
              >
                <strong>{day.date}</strong>
                <div className="my-1">{getIcon(day.main)}</div>
                <div className="text-capitalize small text-muted">{day.description}</div>
                <div className="fw-semibold">{day.temp}°C</div>
              </div>
            ))}
          </div>
        </>
      )}
    </div>
  );
}
