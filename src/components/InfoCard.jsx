import React from "react";

export default function InfoCard({ label, value }) {
  return (
    <div className="card border-0 shadow-sm mb-2">
      <div className="card-body d-flex justify-content-between">
        <span className="text-muted">{label}</span>
        <strong>{value}</strong>
      </div>
    </div>
  );
}
