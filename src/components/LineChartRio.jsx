import { LineChart, Line, XAxis, YAxis, CartesianGrid, Tooltip, ResponsiveContainer } from "recharts";

const data = [
  { dia: "Seg", nivel: 2.3 },
  { dia: "Ter", nivel: 2.8 },
  { dia: "Qua", nivel: 3.0 },
  { dia: "Qui", nivel: 2.7 },
  { dia: "Sex", nivel: 3.2 },
  { dia: "Sáb", nivel: 3.1 },
  { dia: "Dom", nivel: 2.9 },
];

export default function LineChartRio() {
  return (
    <ResponsiveContainer width="100%" height={250}>
      <LineChart data={data}>
        <CartesianGrid strokeDasharray="3 3" />
        <XAxis dataKey="dia" />
        <YAxis unit="m" />
        <Tooltip />
        <Line type="monotone" dataKey="nivel" stroke="#0d6efd" strokeWidth={2} />
      </LineChart>
    </ResponsiveContainer>
  );
}
