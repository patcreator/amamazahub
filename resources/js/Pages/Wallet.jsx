import React from 'react';
import AppLayout from '../Components/AppLayout';
import { Head } from '@inertiajs/react';
import { Wallet as WalletIcon, TrendingUp, History, Gift, CreditCard, ChevronRight, ShieldCheck, Diamond } from 'lucide-react';
import { motion } from 'framer-motion';

export default function Wallet() {
    return (
        <AppLayout>
            <Head title="Wallet - AmazamaHub" />

            <div className="max-w-2xl mx-auto w-full py-8 px-4 pb-24 md:pb-8">
                <div className="flex items-center space-x-3 mb-10">
                    <WalletIcon size={28} className="text-primary" />
                    <h1 className="text-2xl font-black italic tracking-tighter">My Wallet</h1>
                </div>

                {/* Balance Card */}
                <div className="bg-gradient-to-r from-gray-900 to-black border border-gray-800 p-8 rounded-[40px] mb-10 relative overflow-hidden shadow-2xl">
                    <div className="relative z-10 flex flex-col items-center py-6">
                        <p className="text-[10px] text-gray-500 font-black uppercase tracking-[0.3em] mb-4">Total Balance</p>
                        <div className="flex items-center space-x-3 mb-6">
                            <Diamond size={32} className="text-primary" />
                            <span className="text-5xl font-black italic tracking-tighter">0.00</span>
                        </div>
                        <button className="bg-primary text-black text-xs font-black px-12 py-4 rounded-full hover:scale-105 active:scale-95 transition shadow-xl shadow-primary/20 tracking-widest uppercase">Get Coins</button>
                    </div>
                    {/* Decor */}
                    <div className="absolute -bottom-10 -right-10 opacity-5">
                        <WalletIcon size={200} />
                    </div>
                </div>

                {/* Reward System */}
                <div className="space-y-4">
                    <p className="text-[10px] text-gray-500 font-black uppercase tracking-widest px-4">Earning & Rewards</p>
                    <div className="space-y-3">
                        {[
                            { title: 'LIVE Rewards', icon: <Gift className="text-red-400" />, detail: 'Estimated $0.00' },
                            { title: 'Video Gifts', icon: <Diamond className="text-blue-400" />, detail: 'Enabled' },
                            { title: 'Creator Fund', icon: <TrendingUp className="text-green-400" />, detail: 'Check Eligibility' },
                        ].map((item, i) => (
                            <div key={i} className="flex items-center justify-between p-5 bg-gray-900/30 border border-gray-900 rounded-3xl hover:bg-gray-900/50 cursor-pointer transition">
                                <div className="flex items-center space-x-4">
                                    <div className="p-3 bg-gray-800 rounded-2xl">{item.icon}</div>
                                    <span className="font-bold text-gray-200">{item.title}</span>
                                </div>
                                <div className="flex items-center space-x-3">
                                    <span className="text-xs font-black italic text-gray-500 uppercase">{item.detail}</span>
                                    <ChevronRight size={18} className="text-gray-700" />
                                </div>
                            </div>
                        ))}
                    </div>
                </div>

                {/* Security Message */}
                <div className="mt-12 flex items-center space-x-4 p-6 bg-primary/5 border border-primary/10 rounded-3xl">
                    <ShieldCheck className="text-primary flex-shrink-0" size={32} />
                    <p className="text-[10px] font-medium text-gray-400 leading-relaxed uppercase tracking-widest">
                        Your transactions are safe and encrypted. <br />
                        AmazamaHub follows strict security guidelines for your peace of mind.
                    </p>
                </div>
            </div>
        </AppLayout>
    );
}
