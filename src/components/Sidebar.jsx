import React from "react";
import { Home, CircleUserRound, IdCardLanyard, UserPlus, BarChart3 } from "lucide-react";
import testeback from "./testeback.png"; // importe a imagem

export default function Sidebar() {
  const menu = [
    { icon: <BarChart3 size={18} />, label: "Nivel de Água" },
    { icon: <UserPlus size={18} />, label: "Cadastrar" },
    { icon: <CircleUserRound size={18} />, label: "Login Cidadão" },
    { icon: <IdCardLanyard size={18} />, label: "Login Funcionário Público" },
  ];

  return (

    <aside
      className="d-flex flex-column p-3 border-end position-fixed"
      style={{
        width: "240px",
        height: "100vh",
        //backgroundColor: "#040450ff", // cor de fundo
        backgroundImage: `url(${testeback})`, 
        backgroundSize: "cover", // cobre toda a área
        backgroundPosition: "center",
      }}
    >


      <h4 className="fw-bold mb-4 text-white">AQUASENSE UI</h4>

      <ul className="nav flex-column">
        {menu.map((item) => (
          <li key={item.label} className="nav-item mb-2">
            <a href="#" className="fw-bold nav-link d-flex align-items-center text-dark">
              <span className="me-2">{item.icon}</span>
              {item.label}
            </a>
          </li>
        ))}
      </ul>

      <div className="mt-auto small text-muted">
        <i>v1.0 • React + Bootstrap</i>
      </div>
    </aside>
  );
}
