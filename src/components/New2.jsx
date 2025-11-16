import Icon2 from "../assets/img/iconNew2.png";

export default function News1() {
  return (
    <div className="flex flex-col w-full rounded-xl p-4 shadow-lg">
      <h6 className="font-bold">Informe 2 - 02/10/2025</h6>

      <h3
        className="font-bold flex items-center"
        style={{ color: "#115E59", fontWeight: "bold" }}
      >
        <img
          src={Icon2}
          className="object-contain"
          style={{
            width: "24px",
            height: "24px",
            marginRight: "8px",
          }}
          alt="Ícone"
        />
        Ação rápida evita danos
      </h3>

      <p className="mt-2">
        A Defesa Civil realizou uma intervenção preventiva na bacia de contenção de
        águas pluviais do bairro Fundão, em Holambra, após o Sensor Aqua_07
        identificar um aumento repentino no fluxo de água em áreas de risco. As equipes
        isolaram o local, reforçaram barreiras de contenção e normalizaram a situação
        rapidamente, garantindo a segurança dos moradores.
      </p>
    </div>
  );
}

//Título: 25 caracteres.
//Texto: com 360 a 370 caracteres!
