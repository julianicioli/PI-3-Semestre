<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <link rel="icon" type="ico" href="../img/favicon.ico" />

  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="ico" href="./img/favicon.ico" />
  <title>AquaSense UI - Dashboard (Itapira)</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <style>
    body { background-color: #f4f6f8; font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial; }
    .sidebar {
      width: 240px;
      height: 100vh;
      position: fixed;
      left: 0;
      top: 0;
      background-image: url('img/backgroundSidebar.png');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      color: #fff;
      padding: 1.5rem;
    }
    .sidebar a { color: #fff; text-decoration: none; display:flex; align-items:center; margin-bottom:.8rem; font-weight:500; transition:.2s; }
    .sidebar a:hover { opacity:.8; }
    .sidebar i { margin-right:.5rem; }
    main { margin-left:260px; padding:2rem; }
    .card { border:none; border-radius:10px; box-shadow:0 2px 6px rgba(0,0,0,0.08); }

    .gauge-container { width:100%; height:160px; position:relative; }

    /* TREND CHART CARD - mantém o canvas contido e garante espaço para labels */
    .card-trend { height: 350px; position: relative; }
    .chart-area-trend { position: relative; height: calc(100% - 36px); margin-bottom: 6px; } /* 36px reservado para título/pequeno espaço */
    #chartTrend { position: absolute; inset: 0; width:100% !important; height:100% !important; display:block; }

    /* CLIMA CARD - gráfico + forecast dentro do mesmo card, sem sobreposição */
    .card-clima { position: relative; }
    .chart-area-clima {
      height: 260px;           /* altura do gráfico (ajuste se quiser) */
      margin-bottom: 18px;     /* espaço reservado entre gráfico e previsões */
      position: relative;
    }
    #chartClima { position: absolute; inset: 0; width:100% !important; height:100% !important; display:block; }

    .forecast-cards-container {
      display:flex; justify-content:center; gap:12px; flex-wrap:wrap; margin-top:6px;
    }
    .forecast-card {
      border-radius:10px; padding:12px; text-align:center; background:#fff; box-shadow:0 2px 6px rgba(0,0,0,0.06);
      height:110px; display:flex; flex-direction:column; justify-content:center; align-items:center; min-width:100px;
    }
    .forecast-icon img { width:48px; height:48px; object-fit:contain; }
    .forecast-day { font-weight:700; margin-bottom:6px; }
    .forecast-temp { font-weight:700; }
    .forecast-hum { color:#6c757d; font-size:13px; }

    @media(max-width:768px){
      .sidebar{width:100%; height:auto; position:relative;}
      main{margin-left:0;}
      .card-trend{height:260px;}
      .chart-area-clima{height:220px;}
      .forecast-card { min-width:85px; height:auto; padding:8px; }
    }
  </style>
</head>
<body>
  <div class="sidebar">
    <h4 class="fw-bold mb-4 text-center">AQUASENSE UI</h4>
    <a href="TelaCadastroCidadao.html"><i class="bi bi-person-plus"></i> Cadastro Cidadão</a>
    <a href="./view/loginCidadao.php"><i class="bi bi-person-circle"></i> Login Cidadão</a>
    <hr class="border-light">
    <small class="text-white-50 d-block text-center">v2.0 • Chart.js + OpenWeather</small>
  </div>

  <main>
    <h2 class="fw-semibold mb-4">Nível de Água</h2>

    <div class="row g-4 mb-4">
      <div class="col-md-4">
        <div class="card text-center p-3 mb-3">
          <h6 class="fw-semibold mb-3">Nível da Água</h6>
          <div class="gauge-container"><canvas id="gaugeNivel"></canvas></div>
          <div class="fw-bold fs-4 mt-2"><span id="nivelValor">246</span> <span class="text-muted fs-6">mm</span></div>
        </div>

        <div class="card mb-2"><div class="card-body d-flex justify-content-between"><span class="text-muted">Últimas 24h</span><strong id="nivel24h">-- mm</strong></div></div>
        <div class="card"><div class="card-body d-flex justify-content-between"><span class="text-muted">Máximo 24h</span><strong id="nivelMax24h">-- mm</strong></div></div>
      </div>

      <div class="col-md-8">
        <div class="card p-3 card-trend">
          <h6 class="fw-semibold mb-2">Últimos Registros</h6>
          <div class="chart-area-trend">
            <canvas id="chartTrend"></canvas>
          </div>
        </div>
      </div>
    </div>

    <h5 class="fw-semibold mb-3">Clima — Itapira</h5>

    <div class="row g-4">
      <div class="col-md-3">
        <div class="card text-center p-3">
          <h6>Temperatura</h6>
          <div class="gauge-container"><canvas id="gaugeTemp"></canvas></div>
          <strong id="tempValor">-- °C</strong>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card text-center p-3">
          <h6>Umidade Local</h6>
          <div class="gauge-container"><canvas id="gaugeUmid"></canvas></div>
          <strong id="umidValor">--%</strong>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card text-center p-3">
          <h6>Pressão Atmosférica</h6>
          <div class="gauge-container"><canvas id="gaugePress"></canvas></div>
          <strong id="pressValor">-- hPa</strong>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card text-center p-3">
          <h6>Vazão (L/s)</h6>
          <div class="gauge-container"><canvas id="gaugeFlow"></canvas></div>
          <strong id="flowValor">350 L/s</strong>
        </div>
      </div>

    </div>

    <div class="card p-4 mt-4 card-clima">
      <h5 class="fw-semibold mb-3">Previsão do Tempo — Itapira (5 dias)</h5>

      <div class="chart-area-clima">
        <canvas id="chartClima"></canvas>
      </div>

      <div id="forecastRow" class="forecast-cards-container"></div>
    </div>
  </main>

  <script>
    /* ============ CONFIG ============ */
    const OPENWEATHER_KEY = '9cb618c25155e418a43c970d69d07256'; // sua chave
    const CITY = 'Itapira,BR';
    const LOCALE = 'pt_br';

    /* ============ Gauges util ============ */
    function createGauge(ctx, value, min, max, color) {
      return new Chart(ctx, {
        type: 'doughnut',
        data: { datasets: [{ data: [Math.max(0,value - min), Math.max(0, max - value)], backgroundColor: [color, '#e9ecef'], borderWidth: 0 }] },
        options: {
          rotation: -90,
          circumference: 180,
          cutout: '70%',
          plugins: { legend: { display: false }, tooltip: { enabled: false } },
          responsive: true,
          maintainAspectRatio: false
        }
      });
    }

    function updateGauge(chart, value, min, max) {
      chart.data.datasets[0].data = [Math.max(0, value - min), Math.max(0, max - value)];
      chart.update();
    }

    /* ============ CRIAÇÃO DOS GAUGES ============ */
    const gaugeNivel = createGauge(document.getElementById('gaugeNivel'), 246, 0, 400, '#007bff');
    const gaugeTemp  = createGauge(document.getElementById('gaugeTemp'), 24, 0, 40, '#0d6efd');
    const gaugeUmid  = createGauge(document.getElementById('gaugeUmid'), 75, 0, 100, '#00bfa6');
    const gaugePress = createGauge(document.getElementById('gaugePress'), 984, 900, 1100, '#ff8800');

    // gaugeFlow criado SOMENTE UMA VEZ
    const gaugeFlow  = createGauge(document.getElementById('gaugeFlow'), 350, 0, 1000, '#20c997');

    /* ============ Estado inicial (sem bateria) ============ */
    let estado = { nivel: 246, temp: 24.0, umid: 75, press: 984, flow: 350 };

    function updateDisplays() {
      document.getElementById('nivelValor').textContent = Math.round(estado.nivel);
      document.getElementById('tempValor').textContent  = estado.temp.toFixed(1) + ' °C';
      document.getElementById('umidValor').textContent  = Math.round(estado.umid) + '%';
      document.getElementById('pressValor').textContent = Math.round(estado.press) + ' hPa';
      document.getElementById('flowValor').textContent  = Math.round(estado.flow) + ' L/s';
    }

    /* ============ Trend chart (Últimas medições) ============ */
    const ctxTrend = document.getElementById('chartTrend');
    const chartTrend = new Chart(ctxTrend, {
      type: 'line',
      data: {
        labels: [],
        datasets: [{
          label: 'Nível (mm)',
          data: [],
          borderColor: '#007bff',
          backgroundColor: 'rgba(0,123,255,0.12)',
          fill: true,
          tension: 0.25,
          pointRadius: 3
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        layout: { padding: { bottom: 28 } }, // espaço extra para labels
        plugins: { legend: { display: false } },
        scales: {
          x: {
            title: { display: true, text: 'Hora' },
            ticks: { maxRotation: 0, minRotation: 0, autoSkip: true, padding: 6 }
          },
          y: { title: { display: true, text: 'mm' }, min: 0, max: 400 }
        }
      }
    });

    function updateTrendChart(valor) {
      const now = new Date();
      const label = now.toLocaleTimeString();
      chartTrend.data.labels.push(label);
      chartTrend.data.datasets[0].data.push(valor);

      const maxPoints = 30;
      if (chartTrend.data.labels.length > maxPoints) {
        chartTrend.data.labels.shift();
        chartTrend.data.datasets[0].data.shift();
      }

      chartTrend.update();
    }

    /* ============ Simulação local (mantido) ============ */
    function sendToServer(payload) {
      fetch("model/saveSimulacao.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(payload)
      }).then(r => r.text()).then(t => console.log("RETORNO PHP:", t)).catch(e => console.warn(e));
    }

    function simulateStep() {
      // pequenas variações do estado
      estado.nivel = Math.max(0, Math.min(400, estado.nivel + Math.round((Math.random() * 20) - 10)));
      estado.temp  = +(estado.temp + ((Math.random() * 1.4) - 0.7)).toFixed(2);
      estado.umid  = Math.max(0, Math.min(100, estado.umid + Math.round((Math.random() * 6) - 3)));
      estado.press = Math.max(900, Math.min(1100, estado.press + Math.round((Math.random() * 8) - 4)));

      // === VAZÃO (Opção B: linear com variação suave) ===
      // base linear (0..400 mm => 0..1000 L/s) + pequena variação aleatória
      const baseFlow = (estado.nivel / 400) * 1000;
      const variacao = (Math.random() * 80) - 40; // ±40 L/s
      estado.flow = Math.round(Math.max(0, Math.min(1000, baseFlow + variacao)));

      // cor por nível de risco
      const colorFlow = estado.flow > 800 ? '#dc3545' : estado.flow > 500 ? '#ffc107' : '#20c997';
      gaugeFlow.data.datasets[0].backgroundColor[0] = colorFlow;
      updateGauge(gaugeFlow, estado.flow, 0, 1000);

      // atualiza outros gauges e displays
      updateGauge(gaugeNivel, estado.nivel, 0, 400);
      updateGauge(gaugeTemp, estado.temp, 0, 40);
      updateGauge(gaugeUmid, estado.umid, 0, 100);
      updateGauge(gaugePress, estado.press, 900, 1100);

      updateDisplays();
      updateTrendChart(estado.nivel);

      // envia para o servidor (agora com campo flow)
      sendToServer({
        nivel: estado.nivel,
        temperatura: estado.temp,
        umidade: estado.umid,
        pressao: estado.press,
        flow: estado.flow,
        ts: new Date().toISOString()
      });
    }

    updateDisplays();
    simulateStep();
    setInterval(simulateStep, 5000);

    /* ============ Clima / OpenWeather ============ */
    const chartClima = new Chart(document.getElementById('chartClima'), {
      type: 'line',
      data: { labels: [], datasets: [
        { label: 'Temperatura (°C)', data: [], borderColor: '#f39c12', yAxisID: 'y1', fill: false, tension: 0.3 },
        { label: 'Umidade (%)', data: [], borderColor: '#3498db', yAxisID: 'y2', fill: false, tension: 0.3 }
      ]},
      options: {
        responsive: true,
        maintainAspectRatio: false,
        layout: { padding: { bottom: 28 } },
        interaction: { mode: 'index' },
        stacked: false,
        scales: {
          x: { ticks: { maxRotation: 0, minRotation: 0, autoSkip: true, padding: 6 } },
          y1: { type: 'linear', position: 'left', beginAtZero: false, min: -10, max: 50, title: { display: true, text: '°C' } },
          y2: { type: 'linear', position: 'right', beginAtZero: true, min: 0, max: 100, title: { display: true, text: '%' }, grid: { drawOnChartArea: false } }
        },
        plugins: { legend: { position: 'top' } }
      }
    });

    async function fetchWeatherAndForecast() {
      try {
        const weatherURL  = `https://api.openweathermap.org/data/2.5/weather?q=${encodeURIComponent(CITY)}&appid=${OPENWEATHER_KEY}&units=metric&lang=${LOCALE}`;
        const forecastURL = `https://api.openweathermap.org/data/2.5/forecast?q=${encodeURIComponent(CITY)}&appid=${OPENWEATHER_KEY}&units=metric&lang=${LOCALE}`;

        const [wResp, fResp] = await Promise.all([fetch(weatherURL), fetch(forecastURL)]);
        if (!wResp.ok || !fResp.ok) {
          console.error('OpenWeather error', wResp.status, fResp.status);
          return;
        }
        const w = await wResp.json();
        const f = await fResp.json();

        // Atualiza estado climático com dados atuais
        if (w && w.main) {
          estado.temp  = (typeof w.main.temp === 'number') ? w.main.temp : estado.temp;
          estado.umid  = (typeof w.main.humidity === 'number') ? w.main.humidity : estado.umid;
          estado.press = (typeof w.main.pressure === 'number') ? w.main.pressure : estado.press;

          updateGauge(gaugeTemp, estado.temp, -10, 50);
          updateGauge(gaugeUmid, estado.umid, 0, 100);
          updateGauge(gaugePress, estado.press, 900, 1100);
          updateDisplays();
        }

        // Agrupar forecast por dia e escolher ponto preferencialmente do meio-dia
        const forecastByDay = {};
        if (f && Array.isArray(f.list)) {
          f.list.forEach(item => {
            const dt = new Date(item.dt * 1000);
            const dayKey = dt.toISOString().slice(0,10); // YYYY-MM-DD
            if (!forecastByDay[dayKey]) forecastByDay[dayKey] = [];
            forecastByDay[dayKey].push(item);
          });
        }

        const days = Object.keys(forecastByDay).sort();
        const forecastArr = [];
        for (let k of days) {
          if (forecastArr.length >= 5) break;
          const items = forecastByDay[k];
          if (!items || items.length === 0) continue;
          // preferir 12:00 se possível
          let chosen = items.find(it => it.dt_txt && it.dt_txt.indexOf('12:00:00') !== -1) || items[Math.floor(items.length/2)];
          if (chosen) {
            forecastArr.push({
              date: k,
              temp: chosen.main.temp,
              temp_min: chosen.main.temp_min,
              temp_max: chosen.main.temp_max,
              humidity: chosen.main.humidity,
              icon: chosen.weather && chosen.weather[0] && chosen.weather[0].icon ? chosen.weather[0].icon : null,
              description: chosen.weather && chosen.weather[0] && chosen.weather[0].description ? chosen.weather[0].description : ''
            });
          }
        }

        renderForecast(forecastArr);
        updateClimaChart(forecastArr);

      } catch (err) {
        console.error('Erro OpenWeather:', err);
      }
    }

    function renderForecast(list) {
      const container = document.getElementById('forecastRow');
      if (!container) return;
      if (!Array.isArray(list) || list.length === 0) {
        container.innerHTML = '';
        return;
      }

      const html = list.map(d => {
        const date = new Date(d.date);
        const dayName = date.toLocaleDateString('pt-BR', { weekday: 'short' }); // ex: seg
        const iconUrl = d.icon ? `https://openweathermap.org/img/wn/${d.icon}@2x.png` : '';
        const max = Math.round(d.temp_max);
        const min = Math.round(d.temp_min);
        return `
          <div class="forecast-card">
            <div class="forecast-day">${dayName}</div>
            <div class="forecast-icon">${iconUrl ? `<img src="${iconUrl}" alt="${d.description}">` : '—'}</div>
            <div class="forecast-temp">${max}° / <span style="color:#6c757d">${min}°</span></div>
            <div class="forecast-hum">Umid. ${d.humidity}%</div>
          </div>
        `;
      }).join('');
      container.innerHTML = html;
    }

    function updateClimaChart(forecastArr) {
      if (!Array.isArray(forecastArr) || forecastArr.length === 0) {
        chartClima.data.labels = [];
        chartClima.data.datasets[0].data = [];
        chartClima.data.datasets[1].data = [];
        chartClima.update();
        return;
      }
      const labels = forecastArr.map(d => {
        const date = new Date(d.date);
        return date.toLocaleDateString('pt-BR', { weekday: 'short' });
      });
      const temps = forecastArr.map(d => Math.round(d.temp));
      const hums  = forecastArr.map(d => Math.round(d.humidity));

      chartClima.data.labels = labels;
      chartClima.data.datasets[0].data = temps;
      chartClima.data.datasets[1].data = hums;
      chartClima.update();
    }

    // Inicializa busca e define intervalo (5 minutos)
    fetchWeatherAndForecast();
    setInterval(fetchWeatherAndForecast, 300000);

  </script>
</body>
</html>
