import Icon1 from "../assets/img/iconNew1.png";

export default function News1() {
  return (
    <div className="flex flex-col w-full rounded-xl p-4 shadow-lg">
      <h6 className="font-bold">Informe 1 - 25/11/2025</h6>
      <h3 className="font-bold" style={{ color: "#115E59", fontWeight: "bold" }}>
        <img src={Icon1} className="w-6 h-6 object-contain"
          style={{ maxWidth: "24px", maxHeight: "24px", marginRight: "8px" }}
          alt="Ícone" />
        Nível do rio sobe em Itapira</h3>
      <p className="mt-2">
        O rio do Peixe, em Itapira, registrou um leve aumento em seu nível
        após as chuvas persistentes que atingiram a região nas últimas horas. Técnicos da Defesa Civil acompanham continuamente a variação do volume de água e reforçam que,
        apesar da elevação observada, não há indicação de risco imediato de transbordamento no momento.

      </p>
    </div>
  );
}

//Título: 25 caracteres.
//Texto: com 360 a 370 caracteres!