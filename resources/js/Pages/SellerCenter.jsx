import React from 'react';
import AppLayout from '../Components/AppLayout';
import { Head, Link } from '@inertiajs/react';
import { Store, BarChart3, Package, DollarSign, Plus, Settings, MessageCircle, HelpCircle, ChevronRight, Award, Truck } from 'lucide-react';
import { motion } from 'framer-motion';

export default function SellerCenter() {
    const stats = [
        { label: 'Today\'s Sales', value: '$0.00', icon: <DollarSign size={20} className="text-green-400" /> },
        { label: 'Orders', value: '0', icon: <Package size={20} className="text-primary" /> },
        { label: 'Visitors', value: '124', icon: <BarChart3 size={20} className="text-blue-400" /> },
        { label: 'Rating', value: '5.0', icon: <Award size={20} className="text-yellow-400" /> },
    ];

    return (
        <AppLayout>
            <Head title="Seller Center - AmazamaShop" />
            
            <div className="max-w-6xl mx-auto w-full py-8 px-4 pb-24 md:pb-8">
                <div className="flex items-center justify-between mb-10">
                    <div className="flex items-center space-x-3">
                        <Store size={28} className="text-primary" />
                        <h1 className="text-2xl font-black italic tracking-tighter">Seller Center</h1>
                    </div>
                    <button className="bg-primary text-black font-black px-6 py-2 rounded-xl text-sm hover:scale-105 transition flex items-center space-x-2">
                        <Plus size={18} />
                        <span>Add New Product</span>
                    </button>
                </div>

                {/* Dashboard Stats */}
                <div className="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-10">
                    {stats.map((stat, i) => (
                        <div key={i} className="bg-gray-900/30 border border-gray-800 p-6 rounded-[32px] space-y-3">
                            <div className="flex items-center space-x-3">
                                <div className="p-2 bg-gray-800 rounded-xl">{stat.icon}</div>
                                <p className="text-[10px] text-gray-500 font-bold uppercase tracking-wider">{stat.label}</p>
                            </div>
                            <p className="text-2xl font-black italic">{stat.value}</p>
                        </div>
                    ))}
                </div>

                <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
                    {/* Main Tools */}
                    <div className="md:col-span-2 space-y-6">
                        <h2 className="text-sm font-black italic uppercase tracking-widest text-gray-400 px-4">Management Tools</h2>
                        <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            {[
                                { title: 'Products', desc: 'Manage listings and stock', icon: <Package className="text-primary"/> },
                                { title: 'Orders', desc: 'Process and ship commands', icon: <Truck className="text-blue-400"/> },
                                { title: 'Finances', desc: 'Payouts and tax info', icon: <DollarSign className="text-green-400"/> },
                                { title: 'Promotions', desc: 'Coupons and flash deals', icon: <Award className="text-purple-400"/> },
                            ].map((tool, i) => (
                                <div key={i} className="flex items-center space-x-4 p-6 bg-gray-900/20 border border-gray-900 rounded-[32px] cursor-pointer hover:border-gray-700 transition">
                                    <div className="bg-gray-800 p-3 rounded-2xl">{tool.icon}</div>
                                    <div>
                                        <p className="font-black italic text-sm">{tool.title}</p>
                                        <p className="text-[10px] text-gray-500 font-medium">{tool.desc}</p>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>

                    {/* Sidebar / Info */}
                    <div className="space-y-6">
                         <div className="bg-gradient-to-br from-primary/20 to-transparent p-8 rounded-[40px] border border-primary/10">
                            <h3 className="text-xl font-black italic mb-4">Seller Academy</h3>
                            <p className="text-xs text-gray-400 font-medium leading-relaxed mb-6">Learn how to boost your sales by 200% with our new marketing automation tools.</p>
                            <button className="text-primary text-[10px] font-black uppercase tracking-widest hover:underline flex items-center space-x-2">
                                <span>Learn More</span>
                                <ChevronRight size={14} />
                            </button>
                         </div>

                         <div className="space-y-2">
                             {[
                                 { title: 'Chat with Support', icon: <MessageCircle size={18}/> },
                                 { title: 'Shop Settings', icon: <Settings size={18}/> },
                                 { title: 'FAQ', icon: <HelpCircle size={18}/> },
                             ].map((item, i) => (
                                 <div key={i} className="flex items-center justify-between p-4 px-6 hover:bg-white/5 rounded-2xl transition cursor-pointer group">
                                     <div className="flex items-center space-x-3 text-gray-400 group-hover:text-white transition">
                                         {item.icon}
                                         <span className="text-xs font-bold">{item.title}</span>
                                     </div>
                                     <ChevronRight size={14} className="text-gray-800" />
                                 </div>
                             ))}
                         </div>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
