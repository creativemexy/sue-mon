"use client"

import Navbar from "@/components/Navbar";
import Footer from "@/components/Footer";
import CartSidebar from "@/components/CartSidebar";
import SearchModal from "@/components/SearchModal";
import Benefits from "@/pages/Benefits";

export default function BenefitsPage() {
  return (
    <div className="min-h-screen bg-background">
      <Navbar />
      <main>
        <Benefits />
      </main>
      <Footer />
      <CartSidebar />
      <SearchModal />
    </div>
  );
} 