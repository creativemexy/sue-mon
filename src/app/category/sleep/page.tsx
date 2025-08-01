"use client"

import Navbar from "@/components/Navbar";
import Footer from "@/components/Footer";
import CartSidebar from "@/components/CartSidebar";
import SearchModal from "@/components/SearchModal";
import CategorySleep from "@/pages/CategorySleep";

export default function SleepCategoryPage() {
  return (
    <div className="min-h-screen bg-background">
      <Navbar />
      <main>
        <CategorySleep />
      </main>
      <Footer />
      <CartSidebar />
      <SearchModal />
    </div>
  );
} 