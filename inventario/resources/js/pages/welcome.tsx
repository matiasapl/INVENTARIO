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
            <div className="flex min-h-screen flex-col items-center bg-[#FDFDFC] text-[#1b1b18] lg:justify-center lg:p-8 dark:bg-[#0a0a0a]">
                <header className="fixed top-0 right-0 m-6 w-full max-w-[335px] text-sm not-has-[nav]:hidden lg:max-w-4xl">
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
                <div className="m-4 flex flex-col border-4 p-4 font-bold text-white">
                    <h1>Web App - Inventarios</h1>
                    <span>Autor: Matias APL</span>
                    <br />
                    <a
                        href="https://mapl.dev/"
                        target="_blank"
                        rel="noopener noreferrer"
                        className="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
                    >
                        Portfolio
                    </a>
                </div>
                <div className="m-4 font-bold flex flex-col border-4 p-4 text-white">
                    <h1>Resumen</h1>
                    <span>Autor: Matias APL</span>
                    <br />
                </div>
                <div className="hidden h-14.5 lg:block"></div>
            </div>
        </>
    );
}
