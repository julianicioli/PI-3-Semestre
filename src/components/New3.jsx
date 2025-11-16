import Icon3 from "../assets/img/iconNew3.png";

export default function News1() {
  return (
    <div className="flex flex-col w-full rounded-xl p-4 shadow-lg">
      <h6 className="font-bold">Informe 2 - 04/11/2025</h6>

      <h3
        className="font-bold flex items-center"
        style={{ color: "#115E59", fontWeight: "bold" }}
      >
        <img
          src={Icon3}
          className="object-contain"
          style={{
            width: "24px",
            height: "24px",
            marginRight: "8px",
          }}
          alt="Ícone"
        />
        Sensores evitam enchentes
      </h3>

      <p className="mt-2">
        As bacias de contenção de águas pluviais armazenam o excesso de chuva e reduzem
        riscos de alagamentos em áreas rurais. Elas controlam o escoamento superficial,
        evitando erosão e danos. Com sensores de nível de água, o monitoramento fica mais
        preciso, permitindo ações preventivas e aumentando a segurança contra enchentes e
        garantindo proteção às propriedades vizinhas.
      </p>
    </div>
  );
}

//Título: 25 caracteres.
//Texto: com 360 a 370 caracteres!
