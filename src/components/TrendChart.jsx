import React from "react";
import { AreaChart, Area, XAxis, YAxis, Tooltip, ResponsiveContainer, Legend } from "recharts";

export default function TrendChart({ data }) {
  return (
    <ResponsiveContainer width="100%" height={300}>
      <AreaChart data={data}>
        <defs>
          <linearGradient id="depthColor" x1="0" y1="0" x2="0" y2="1">
            <stop offset="5%" stopColor="#0d6efd" stopOpacity={0.8} />
            <stop offset="95%" stopColor="#0d6efd" stopOpacity={0} />
          </linearGradient>
        </defs>
        <XAxis dataKey="dia" />
        <YAxis />
        <Tooltip />
        <Legend />
        <Area type="monotone" dataKey="nivel" stroke="#0d6efd" fill="url(#depthColor)" name="Nivel de Agua" />
      </AreaChart>
    </ResponsiveContainer>
  );
}
