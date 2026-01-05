import { index } from '@/actions/App/Http/Controllers/ProductController';
import { login, register, } from '@/routes';
import { type SharedData } from '@/types';
import { Button } from '@headlessui/react';
import { Head, Link, usePage } from '@inertiajs/react';

export default function Welcome({
    canRegister = true,
}: {
    canRegister?: boolean;
}) {
    const { auth } = usePage<SharedData>().props;

    return (
        <>
            <Head title="En Desarrollo">
                <link rel="preconnect" href="https://fonts.bunny.net" />
                <link
                    href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600"
                    rel="stylesheet"
                />
            </Head>
            <div className="flex min-h-screen flex-col items-end bg-[#FDFDFC] text-[#1b1b18] lg:justify-center lg:p-8 dark:bg-[#0a0a0a]">
                <header className="static top-0 right-0 m-6 w-full max-w-[335px] text-sm not-has-[nav]:hidden lg:max-w-4xl">
                    <nav className="items-top flex justify-end">
                        {auth.user ? (
                            <Link
                                href={index().url}
                                className="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
                            >
                                Dashboard
                            </Link>
                        ) : (
                            <>
                                <Link
                                    href={login()}
                                    className="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
                                >
                                    Iniciar Sesion
                                </Link>
                                {canRegister && (
                                    <Link
                                        href={register()}
                                        className="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
                                    >
                                        Registrar
                                    </Link>
                                )}
                            </>
                        )}
                    </nav>
                </header>
                <div className="m-4 flex min-w-full flex-col border-4 p-4 font-bold text-white">
                    <h2>Esto es un MVP usalo bajo tu propio riesgo</h2> <br />{' '}
                    <br />
                    <h1>Web App - Inventarios</h1>
                    <span>Autor: Matias APL</span>
                    <br />
                    <a
                        href="https://mapl.dev/"
                        target="_blank"
                        rel="noopener noreferrer"
                        className="mb-4 inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
                    >
                        Portfolio
                    </a>
                    <a
                        href="https://drive.google.com/drive/folders/1TszLGK-xCxbZ73TxGU_z2nY5gUpTxB-3?usp=sharing"
                        target="_blank"
                        rel="noopener noreferrer"
                        className="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
                    >
                        Imagenes del proyecto
                    </a>
                </div>
                <div className="m-4 flex min-w-full flex-col border-4 p-4 font-bold text-white">
                    <h1>Mensaje del Desarrollador: </h1>
                    <p>
                        Este es un proyecto personal que pretende convertirse en
                        un Saas de gestion de Inventarios.
                        <br />
                        Si quieres pruebalo por ahora es gratis, si quieres dar
                        feedback envia un correo a Polhwein.matias@gmail.com{' '}
                        <br />
                        <br />
                        Que tiene?
                        <br />
                        Creacion de productos [Registra productos con codigo,
                        nombre, descripcion, precio unitario y m3_unitario +
                        stock]. <br />
                        Registra aumentos y resta de stock de forma unitaria.{' '}
                        <br />
                        Trazabilidad - cada vez que hagas un cambio de stock un
                        registro o una eliminacion quedara registrada y visible
                        para ti <br />
                        Dashboard - visualiza facilmente tus productos y su
                        stock + precio y volumen <br />
                        Que quiero lograr con este proyecto?: <br />
                        Quiero que el control de inventarios no sea algo en un
                        excel que se gaste mas tiempo en mantener que en crecer{' '}
                        <br />
                        por un precio accesible tanto para pequeños negocios
                        como para grandes empresas de la agro industria chilena{' '}
                        <br />
                        <br />
                        Este proyecto esta terminado?: <br />
                        No Tendra actualizaciones periodicas, Mi idea es
                        permanecer en un desarrollo continuo asta ser el mejor
                        en este nicho <br />
                        <br />
                        que sigue? <br />
                        Como veras todo es demaciado manual si debes registrar
                        stock desde web es lo mismo que un excel <br />
                        por esto mismo el siguiente paso es crear una app
                        android y una seccion que te permita <br />
                        imprimir Codigos QR y colocar en tus productos para que
                        con un solo escaneo puedas controlar el stock <br />
                        y esto te permita tener mejor trazabilidad y centrarte
                        en crecer en vez de mantener <br />
                        <br />
                        sugerencias?: <br />
                        eres el encargado del inventarios de un negocio y este
                        te parece un buen proyecto que podria ayudarte pero
                        crees que ahy cosas que estorban sobran o faltan?:{' '}
                        <br />
                        enviame un mail a Polhweinmatias@gmail.com con el asunto
                        Sugerencia Inventario <br />
                        <br />
                        porque no tienes un formulario de sugerencias?: <br />
                        aun no esta completa la base del proyecto y el foco esta
                        en la base pero eventualmente lo habra <br />
                        <br />
                        puedo usarlo?: <br />
                        adelante sin problemas aunque esta en desarrollo desde
                        esta version no habra perdida de datos y es
                        suficientemente seguro <br />
                        <br />
                        bugs, exploits?: <br />
                        no tengo dinero para pagar por auditorias pero si
                        encuentras uno enviame un mail a
                        Polhweinmatias@gmail.com con el asunto [ BUGS INVENTARIO
                        ] <br />y con gusto lo corrigo (comprueba que sea
                        replicable) <br />
                        <br />
                        que pasara cuando sea de pago?: <br />
                        resiviras un mail con 1 mes de anticipacion avisandote
                        de los cambios para que decidas si pagaras por el
                        servicio o te retiraras y tambien habra un banner en
                        esta web con una cuenta regresiva <br />
                    </p>
                    <br />
                </div>
                <div className="hidden h-14.5 lg:block"></div>
            </div>
        </>
    );
}
