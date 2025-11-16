import { BarChart, Bar, XAxis, YAxis, Tooltip, ResponsiveContainer } from "recharts";

const data = [
  { dia: "Seg", chuva: 10 },
  { dia: "Ter", chuva: 25 },
  { dia: "Qua", chuva: 5 },
  { dia: "Qui", chuva: 15 },
  { dia: "Sex", chuva: 30 },
  { dia: "Sáb", chuva: 20 },
  { dia: "Dom", chuva: 8 },
];

export default function BarChartRio() {
  return (
    <ResponsiveContainer width="100%" height={250}>
      <BarChart data={data}>
        <XAxis dataKey="dia" />
        <YAxis unit="mm" />
        <Tooltip />
        <Bar dataKey="chuva" fill="#0d6efd" />
      </BarChart>
    </ResponsiveContainer>
  );
}
