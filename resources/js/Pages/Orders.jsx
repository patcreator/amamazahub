import React from 'react';
import AppLayout from '../Components/AppLayout';
import { Head, Link } from '@inertiajs/react';
import { Truck, Package, Clock, CheckCircle2, ChevronRight, ShoppingBag, Search } from 'lucide-react';
import { motion } from 'framer-motion';

export default function Orders() {
    const orders = [
        { id: '#AMZ-9921', status: 'In Transit', items: 2, total: '$74.99', date: 'Mar 18, 2024', image: 'https://images.pexels.com/photos/190819/pexels-photo-190819.jpeg?auto=compress&cs=tinysrgb&w=300' },
        { id: '#AMZ-8843', status: 'Delivered', items: 1, total: '$15.00', date: 'Mar 12, 2024', image: 'https://images.pexels.com/photos/1474132/pexels-photo-1474132.jpeg?auto=compress&cs=tinysrgb&w=300' },
    ];

    return (
        <AppLayout>
            <Head title="Orders - AmazamaShop" />
            
            <div className="max-w-4xl mx-auto w-full py-8 px-4 pb-24 md:pb-8">
                <div className="flex items-center justify-between mb-10">
                    <h1 className="text-2xl font-black italic tracking-tighter">My Orders</h1>
                    <div className="flex space-x-2">
                         <div className="bg-gray-900/50 border border-gray-800 rounded-full px-4 py-1.5 flex items-center space-x-2">
                             <Search size={14} className="text-gray-500" />
                             <input type="text" placeholder="Search orders" className="bg-transparent border-none text-xs focus:ring-0 w-24" />
                         </div>
                    </div>
                </div>

                {/* Tabs */}
                <div className="flex space-x-8 border-b border-gray-900 mb-8 overflow-x-auto noscrollbar">
                    {['All', 'To Pay', 'To Ship', 'To Receive', 'Completed'].map((tab, i) => (
                        <button key={i} className={`pb-4 text-xs font-black italic tracking-widest relative whitespace-nowrap ${i === 0 ? 'text-white' : 'text-gray-500'}`}>
                            {tab}
                            {i === 0 && <div className="absolute bottom-0 left-0 right-0 h-1 bg-primary rounded-full"></div>}
                        </button>
                    ))}
                </div>

                {/* Order List */}
                <div className="space-y-4">
                    {orders.map((order) => (
                        <div key={order.id} className="bg-gray-900/20 border border-gray-900 rounded-[32px] p-6 hover:border-gray-800 transition group cursor-pointer">
                            <div className="flex items-center justify-between mb-6">
                                <div className="flex items-center space-x-3">
                                    <Package size={20} className="text-primary" />
                                    <span className="text-xs font-black italic text-gray-300">Order {order.id}</span>
                                </div>
                                <div className={`flex items-center space-x-1.5 px-3 py-1 rounded-full text-[8px] font-black uppercase tracking-widest ${order.status === 'Delivered' ? 'bg-green-500/10 text-green-400' : 'bg-primary/10 text-primary'}`}>
                                    {order.status === 'Delivered' ? <CheckCircle2 size={10} /> : <Clock size={10} />}
                                    <span>{order.status}</span>
                                </div>
                            </div>
                            
                            <div className="flex items-center space-x-4">
                                <div className="w-20 h-20 rounded-2xl overflow-hidden bg-black flex-shrink-0">
                                    <img src={order.image} className="w-full h-full object-cover" />
                                </div>
                                <div className="flex-1 min-w-0">
                                    <p className="text-sm font-bold text-gray-200 truncate">Premium Order Content & more</p>
                                    <p className="text-[10px] text-gray-500 font-bold uppercase mt-1">{order.items} Items • Placed on {order.date}</p>
                                    <div className="flex items-center justify-between mt-3">
                                        <span className="text-lg font-black italic">{order.total}</span>
                                        <button className="text-xs font-black italic text-primary hover:underline flex items-center space-x-1">
                                            <span>Track Order</span>
                                            <ChevronRight size={14} />
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    ))}
                </div>

                <div className="mt-12 text-center py-10">
                     <ShoppingBag size={48} className="mx-auto text-gray-800 mb-4 opacity-20" />
                     <p className="text-[10px] text-gray-600 font-black uppercase tracking-widest">Looking for more deals?</p>
                     <Link href="/shop" className="text-primary text-xs font-black italic mt-2 inline-block hover:underline">Continue Shopping</Link>
                </div>
            </div>
        </AppLayout>
    );
}
