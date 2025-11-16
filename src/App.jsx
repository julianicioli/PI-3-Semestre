import React from "react";
import Sidebar from "./components/Sidebar";
import GaugeCard from "./components/GaugeCard.jsx";
import TrendChart from "./components/TrendChart";
import InfoCard from "./components/InfoCard";
import Clima from "./components/Clima";
import News from "./components/News"; // ACRESCENTAR NEWS
import { dataTrend } from "./data";

import News1 from "./components/New1.jsx";
import News2 from "./components/New2.jsx";
import News3 from "./components/New3.jsx";

function App() {
  return (
    <div className="d-flex" style={{ backgroundColor: "#f4f6f8", minHeight: "100vh" }}>
      <Sidebar />
      <main className="flex-grow-1 p-4" style={{ marginLeft: "240px" }}>
        <h2 className="fw-semibold mb-4">Nível de Água</h2>


        <div className="row g-4 mb-4">
          <div className="col-md-4">
            <GaugeCard title="Nivel da Água" value={246} unit="Milímetros" color="#007bff" />
            <InfoCard label="Útimas 24h" value="-45 mm" />
            <InfoCard label="Máximo 24h" value="320 mm" />
          </div>

          <div className="col-md-8">
            <div className="card shadow-sm border-0">
              <div className="card-body">
                <h6 className="fw-semibold mb-3">Últimos 7 Dias</h6>
                <TrendChart data={dataTrend} />
              </div>
            </div>
          </div>
        </div>

        {/* LINHA 2 */}
        <h5 className="fw-semibold mb-3">Clima</h5>
        <div className="row g-4">
          <div className="col-md-3">
            <GaugeCard title="Temperatura" value={4.8} unit="°C" color="#0d6efd" min={-10} max={40} />
          </div>
          <div className="col-md-3">
            <GaugeCard title="Umidade Local" value={93} unit="% RH" color="#00bfa6" min={0} max={100} />
          </div>
          <div className="col-md-3">
            <GaugeCard title="Vazão de água (min)" value={984} unit="hPa" color="#ff8800" min={940} max={1080} />
          </div>
          <div className="col-md-3">
            <GaugeCard title="Bateria" value={3598} unit="mV" color="#dc3545" min={3000} max={4200} />
          </div>
        </div>



        
          <div className="col-12">
            <Clima />
          </div>

          <div className="row g-4 mb-4 mt-1">

            <div className="col-4">
              <News1 />
            </div>

            <div className="col-4">
              <News2 />
            </div>

                <div className="col-4">
              <News3 />
            </div>

          </div>





      </main >
    </div >
  );
}

export default App;
