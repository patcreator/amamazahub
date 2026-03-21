import React from 'react';
import AppLayout from '../Components/AppLayout';
import { Head, Link } from '@inertiajs/react';
import { CreditCard, Wallet, Plus, ShieldCheck, ChevronRight, Check } from 'lucide-react';
import { motion } from 'framer-motion';

export default function Payments() {
    const cards = [
        { id: 1, type: 'Visa', last4: '4242', expiry: '12/26', isDefault: true, color: 'from-blue-600 to-blue-800' },
        { id: 2, type: 'Mastercard', last4: '8843', expiry: '08/25', isDefault: false, color: 'from-orange-600 to-red-600' },
    ];

    return (
        <AppLayout>
            <Head title="Payments - AmazamaShop" />
            
            <div className="max-w-2xl mx-auto w-full py-8 px-4 pb-24 md:pb-8">
                <div className="flex items-center justify-between mb-10">
                    <h1 className="text-2xl font-black italic tracking-tighter">Payment Methods</h1>
                    <button className="p-2 bg-primary/10 border border-primary/20 rounded-full text-primary hover:bg-primary/20 transition"><Plus size={22} /></button>
                </div>

                <div className="space-y-6">
                    {cards.map((card) => (
                        <div key={card.id} className="relative group perspective-1000">
                            <div className={`bg-gradient-to-br ${card.color} rounded-[32px] p-8 h-48 flex flex-col justify-between shadow-2xl relative overflow-hidden transition-transform duration-500 group-hover:rotate-x-12`}>
                                <div className="flex justify-between items-start">
                                    <div className="flex flex-col">
                                        <p className="text-[10px] font-black uppercase tracking-widest opacity-80 mb-1">AmazamaPay Premium</p>
                                        <div className="text-xl font-black italic">{card.type}</div>
                                    </div>
                                    <ShieldCheck className="text-white fill-white/10" size={32} />
                                </div>
                                <div className="space-y-4">
                                    <div className="text-2xl font-black italic tracking-[0.3em]">•••• •••• •••• {card.last4}</div>
                                    <div className="flex justify-between items-end">
                                         <p className="text-xs font-bold uppercase tracking-widest">{card.expiry}</p>
                                         <div className="flex space-x-2">
                                             {card.isDefault && <span className="bg-white/20 px-3 py-1 rounded-full text-[8px] font-black uppercase tracking-widest backdrop-blur-md">Default</span>}
                                         </div>
                                    </div>
                                </div>
                                {/* Tech decor */}
                                <div className="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full -mr-10 -mt-10 blur-xl"></div>
                            </div>
                        </div>
                    ))}
                </div>

                <div className="mt-12 space-y-4">
                    <p className="text-[10px] text-gray-500 font-black italic uppercase tracking-widest px-4">Other Methods</p>
                    <div className="bg-gray-900/30 border border-gray-900 rounded-[32px] overflow-hidden">
                        {[
                            { title: 'Amazama Wallet', icon: <Wallet size={18}/>, detail: 'Balance: $0.00' },
                            { title: 'PayPal', icon: <CreditCard size={18}/>, detail: 'Link Account' },
                        ].map((method, i) => (
                            <div key={i} className="flex items-center justify-between p-6 hover:bg-white/5 transition border-b border-gray-900 last:border-0 cursor-pointer group">
                                <div className="flex items-center space-x-4">
                                    <div className="p-3 bg-gray-800 rounded-2xl text-gray-400 group-hover:text-primary transition">{method.icon}</div>
                                    <span className="text-sm font-bold text-gray-200">{method.title}</span>
                                </div>
                                <div className="flex items-center space-x-3">
                                    <span className="text-[10px] font-black italic text-gray-500">{method.detail}</span>
                                    <ChevronRight size={18} className="text-gray-800" />
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
