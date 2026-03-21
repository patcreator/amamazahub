import React from 'react';
import AppLayout from '../Components/AppLayout';
import { Head, Link } from '@inertiajs/react';
import { Search, ShoppingBag, Filter, ArrowLeft, TrendingUp, Clock, Grid, List } from 'lucide-react';
import { motion } from 'framer-motion';

export default function ShopSearch() {
    const history = ['Ring Light', 'Microphone', 'Vlog kit', 'Studio Headphones'];
    const trending = ['Amazama Pro Lens', 'Wireless Lapel Mic', 'Creator Desk', 'Gimbal Stabilizer'];

    return (
        <AppLayout>
            <Head title="Search Shop - AmazamaShop" />
            
            <div className="max-w-4xl mx-auto w-full py-8 px-4 pb-24 md:pb-8">
                {/* Search Bar */}
                <div className="flex items-center space-x-4 mb-10">
                    <Link href="/shop" className="p-2 border border-gray-800 rounded-full hover:bg-gray-900 transition"><ArrowLeft size={20}/></Link>
                    <div className="flex-1 relative group">
                        <Search size={18} className="absolute left-5 top-1/2 -translate-y-1/2 text-gray-500 group-focus-within:text-primary transition" />
                        <input 
                            type="text" 
                            placeholder="Find products by name or category..." 
                            className="w-full bg-gray-900/60 border border-gray-800 rounded-full py-4 px-14 text-sm font-semibold focus:outline-none focus:border-primary transition"
                        />
                         <button className="absolute right-6 top-1/2 -translate-y-1/2 text-gray-500 hover:text-white"><Filter size={18} /></button>
                    </div>
                </div>

                <div className="grid grid-cols-1 md:grid-cols-2 gap-12">
                    {/* Recent History */}
                    <div className="space-y-6">
                        <div className="flex items-center justify-between px-2">
                             <div className="flex items-center space-x-2 text-[10px] font-black italic uppercase tracking-widest text-gray-500">
                                 <Clock size={14}/>
                                 <span>Recent Searches</span>
                             </div>
                             <button className="text-[10px] font-black italic text-red-500 uppercase hover:underline">Clear</button>
                        </div>
                        <div className="space-y-2">
                            {history.map((item, i) => (
                                <Link key={i} href="/shop" className="flex items-center justify-between p-4 bg-gray-900/20 border border-transparent hover:border-gray-800 rounded-2xl transition group">
                                     <span className="text-sm font-medium text-gray-300">{item}</span>
                                     <ShoppingBag size={14} className="text-gray-800 group-hover:text-primary transition" />
                                </Link>
                            ))}
                        </div>
                    </div>

                    {/* Trending Now */}
                    <div className="space-y-6">
                         <div className="flex items-center space-x-2 px-2 text-[10px] font-black italic uppercase tracking-widest text-gray-500">
                             <TrendingUp size={14} className="text-primary"/>
                             <span>Trending Now</span>
                         </div>
                         <div className="flex flex-wrap gap-3">
                             {trending.map((item, i) => (
                                 <Link key={i} href="/shop" className="px-5 py-3 bg-gray-900/40 border border-gray-800 rounded-2xl text-xs font-bold hover:bg-white text-gray-300 hover:text-black transition transform active:scale-95">
                                     {item}
                                 </Link>
                             ))}
                         </div>

                         <div className="bg-gradient-to-br from-primary/5 to-transparent border border-primary/10 rounded-[32px] p-8 mt-10">
                              <h3 className="text-lg font-black italic mb-2 tracking-tight">Shop by Creators</h3>
                              <p className="text-xs text-gray-500 font-medium leading-relaxed mb-6">Discover products recommended and sold by your favorite content creators.</p>
                              <Link href="/following" className="text-primary text-[10px] font-black italic tracking-widest uppercase hover:underline">View Creators</Link>
                         </div>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
