import React from 'react';
import AppLayout from '../Components/AppLayout';
import { Head, Link } from '@inertiajs/react';
import { Tag, Sparkles, Clock, ChevronRight, ShoppingBag, Gift, Zap } from 'lucide-react';
import { motion } from 'framer-motion';

export default function Promotions() {
    const deals = [
        { id: 1, title: 'Welcome Gift', desc: 'Get $10 off your first purchase over $30.', code: 'AMZ10', color: 'from-primary to-orange-600' },
        { id: 2, title: 'March Madness', desc: 'Premium studio gear at 30% discount.', code: 'STUDIO30', color: 'from-blue-600 to-purple-600' },
        { id: 3, title: 'Free Shipping', desc: 'No minimum spend on all electronics.', code: 'SHIPFREE', color: 'from-green-600 to-teal-600' },
    ];

    return (
        <AppLayout>
            <Head title="Promotions - AmazamaShop" />
            
            <div className="max-w-4xl mx-auto w-full py-8 px-4 pb-24 md:pb-8">
                <div className="flex items-center space-x-3 mb-12">
                    <Tag size={28} className="text-primary" />
                    <h1 className="text-2xl font-black italic tracking-tighter">Your Coupons & Deals</h1>
                </div>

                {/* Featured Promo */}
                <div className="bg-gradient-to-br from-gray-900 to-black border border-gray-800 rounded-[40px] p-10 mb-12 relative overflow-hidden flex flex-col md:flex-row items-center justify-between">
                    <div className="relative z-10 space-y-4 text-center md:text-left">
                        <div className="flex items-center justify-center md:justify-start space-x-2 text-primary font-black italic uppercase tracking-widest text-[10px]">
                            <Zap size={14} />
                            <span>Exclusive Deal</span>
                        </div>
                        <h2 className="text-4xl font-black italic tracking-tighter max-w-sm leading-tight">Claim Your Creator Starter Pack Discount</h2>
                        <button className="bg-white text-black font-black px-12 py-4 rounded-2xl hover:scale-105 transition shadow-2xl">Claim Now</button>
                    </div>
                    <Gift size={180} className="text-primary/5 absolute -right-4 -bottom-4 translate-x-1/2 translate-y-1/2 rotate-12" />
                </div>

                {/* Coupon Grid */}
                <div className="space-y-6">
                    <p className="text-[10px] text-gray-500 font-black italic uppercase tracking-widest px-4">Available Coupons</p>
                    {deals.map((deal) => (
                        <div key={deal.id} className="relative group cursor-pointer">
                            <div className={`bg-gradient-to-r ${deal.color} p-0.5 rounded-[32px] overflow-hidden`}>
                                <div className="bg-black/90 backdrop-blur-md p-8 rounded-[30px] flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0 relative">
                                    <div className="space-y-2 text-center md:text-left">
                                        <h3 className="text-xl font-black italic tracking-tight">{deal.title}</h3>
                                        <p className="text-xs text-gray-400 font-medium">{deal.desc}</p>
                                    </div>
                                    <div className="flex items-center space-x-6">
                                        <div className="bg-white/5 border border-white/10 px-6 py-3 rounded-2xl">
                                             <span className="text-lg font-black italic tracking-widest text-primary">{deal.code}</span>
                                        </div>
                                        <button className="bg-white text-black text-[10px] font-black px-6 py-3 rounded-xl hover:scale-105 transition uppercase tracking-widest">Apply</button>
                                    </div>
                                    {/* Perforation effect */}
                                    <div className="absolute top-1/2 -left-3 -translate-y-1/2 w-6 h-6 bg-black rounded-full"></div>
                                    <div className="absolute top-1/2 -right-3 -translate-y-1/2 w-6 h-6 bg-black rounded-full"></div>
                                </div>
                            </div>
                        </div>
                    ))}
                </div>

                <div className="mt-16 p-8 border border-dashed border-gray-800 rounded-[40px] text-center">
                    <p className="text-xs text-gray-600 font-medium">Looking for more? Follow our official Shop account for daily drops!</p>
                </div>
            </div>
        </AppLayout>
    );
}
