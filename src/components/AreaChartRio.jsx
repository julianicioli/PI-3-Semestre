import { AreaChart, Area, XAxis, YAxis, CartesianGrid, Tooltip, ResponsiveContainer } from "recharts";

const data = [
  { hora: "00h", vazao: 150 },
  { hora: "06h", vazao: 200 },
  { hora: "12h", vazao: 250 },
  { hora: "18h", vazao: 220 },
  { hora: "24h", vazao: 180 },
];

export default function AreaChartRio() {
  return (
    <ResponsiveContainer width="100%" height={250}>
      <AreaChart data={data}>
        <defs>
          <linearGradient id="colorVazao" x1="0" y1="0" x2="0" y2="1">
            <stop offset="5%" stopColor="#06b6d4" stopOpacity={0.8} />
            <stop offset="95%" stopColor="#06b6d4" stopOpacity={0} />
          </linearGradient>
        </defs>
        <CartesianGrid strokeDasharray="3 3" />
        <XAxis dataKey="hora" />
        <YAxis unit="L/s" />
        <Tooltip />
        <Area type="monotone" dataKey="vazao" stroke="#06b6d4" fill="url(#colorVazao)" />
      </AreaChart>
    </ResponsiveContainer>
  );
}
