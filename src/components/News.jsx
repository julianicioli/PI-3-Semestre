// INFORME – CODIGO COM TROCA DE NOTICIAS A CADA 5 SEGUNDOS:
// Nao usei esse componente

import React, { useState, useEffect } from "react";
import { ChevronLeft, ChevronRight } from "lucide-react";

const noticias = [
    "Notícia 1: Evento ambiental na cidade.",
    "Notícia 2: Novas medidas de economia de água.",
    "Notícia 3: Projeto de reflorestamento urbano.",
    "Notícia 4: Alerta de nível de água em rios locais.",
];

export default function NoticiasBoomerang() {
    const [index, setIndex] = useState(0);

    // Troca automática de notícia a cada 5 segundos
    useEffect(() => {
        const timer = setInterval(() => {
            setIndex((prev) => (prev + 1) % noticias.length);
        }, 5000);
        return () => clearInterval(timer);
    }, []);

    const prevNoticia = () => {
        setIndex((prev) => (prev - 1 + noticias.length) % noticias.length);
    };

    const nextNoticia = () => {
        setIndex((prev) => (prev + 1) % noticias.length);
    };

    return (

        <div className="flex flex-col w-full max-w-md bg-yellow-100 rounded-xl p-4 shadow-lg relative">
            
            {/* Setas de navegação */}

            <div
                className="absolute top-1/2 right-2 transform -translate-y-1/2 cursor-pointer"
                onClick={nextNoticia}
            >
                <ChevronRight size={24} className="text-yellow-800" />
            </div>

            <h3 className="font-bold mb-2 text-yellow-800">Informes</h3>

            {/* Conteúdo boomerang */}
            <div className="overflow-hidden h-24 flex items-center">
                <p className="text-yellow-900 font-medium transition-transform duration-500 ease-in-out transform translate-x-0">
                    {noticias[index]}
                </p>
            </div>

        </div>
    );
}


