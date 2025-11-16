import React from "react";
import GaugeChart from "react-gauge-chart";

export default function GaugeCard({ title, value, unit, color, min = 0, max = 100 }) {
  const percent = (value - min) / (max - min);

  return (
    <div className="card shadow-sm border-0 mb-3">
      <div className="card-body text-center">
        <h6 className="fw-semibold mb-3">{title}</h6>
        <GaugeChart
          id={`gauge-${title}`}
          nrOfLevels={30}
          colors={[color]}
          arcWidth={0.2}
          percent={percent}
          hideText
        />
        <div className="fw-bold fs-4 mt-2">
          {value} <span className="text-muted fs-6">{unit}</span>
        </div>
      </div>
    </div>
  );
}
